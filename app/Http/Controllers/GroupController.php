<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Muestra la pantalla principal de grupos (Feed + Sidebar)
     */
    public function index()
    {
        $user = Auth::user();

        // 1. MIS GRUPOS: Grupos donde el usuario está registrado como miembro
        // Usamos whereHas para filtrar por la tabla pivote group_user
        $myGroups = Group::whereHas('members', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->withCount('members')->get();

        // 2. SUGERENCIAS: Grupos donde el usuario NO es miembro
        $suggestedGroups = Group::whereDoesntHave('members', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->withCount('members')
        ->inRandomOrder()
        ->take(8)
        ->get();

        // 3. FEED DE ACTIVIDAD: Posts que pertenecen a mis grupos
        // Obtenemos los IDs de mis grupos
        $myGroupIds = $myGroups->pluck('id');

        // Buscamos posts donde el 'muro' sea uno de mis grupos
        $feedPosts = Post::where('wall_type', Group::class)
                         ->whereIn('wall_id', $myGroupIds)
                         ->with(['author', 'wall']) // Cargamos datos del autor y del grupo
                         ->latest()
                         ->take(20)
                         ->get();

        return view('groups.index', compact('myGroups', 'suggestedGroups', 'feedPosts'));
    }

    /**
     * Muestra el formulario para crear un grupo
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Guarda el grupo en BD
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'privacy' => 'required|in:public,private',
            'description' => 'nullable|string'
        ]);

        // Crear slug simple
        $slug = \Illuminate\Support\Str::slug($request->name) . '-' . rand(1000, 9999);

        $group = Group::create([
            'user_id' => Auth::id(), // Creador
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'privacy' => $request->privacy,
        ]);

        // IMPORTANTE: El creador debe ser miembro automáticamente (y admin)
        $group->members()->attach(Auth::id(), ['role' => 'admin', 'status' => 'active']);

        return redirect()->route('groups.index')->with('status', 'Grupo creado correctamente');
    }

    /**
     * Mostrar un grupo individual
     */
    public function show($slug)
    {
        // Cargamos el grupo y sus posts (con autor y comentarios)
        $group = Group::where('slug', $slug)
                      ->with(['posts.author', 'posts.comments', 'posts.reactions'])
                      ->firstOrFail();

        return view('groups.show', compact('group'));
    }

    /**
     * Guardar un post en el grupo
     */
    public function storePost(Request $request, $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();

        // 1. Validación
        $request->validate([
            'content' => 'required_without:image|nullable|string',
            'image'   => 'nullable|image|max:10240',
        ]);

        // 2. Imagen
        $attachments = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('groups-posts', 'public');
            $attachments = [$path];
        }

        // 3. Crear Post
        // NOTA: Aquí el 'author' es el Usuario conectado (Auth::id())
        // El 'wall' (muro) es el Grupo ($group->id)
        \App\Models\Post::create([
            'user_id'     => auth()->id(),            // Dueño del registro
            'author_type' => \App\Models\User::class, // Quien escribe (Usuario)
            'author_id'   => auth()->id(),            
            
            'wall_type'   => \App\Models\Group::class,// Dónde se escribe (Grupo)
            'wall_id'     => $group->id,
            
            'content'     => $request->content,
            'attachments' => $attachments,
            'privacy'     => 'public', // Los posts de grupo suelen heredar la privacidad del grupo
        ]);

        return back();
    }
}