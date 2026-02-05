<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Mostrar el formulario de creación
    public function create()
    {
        return view('pages.create');
    }

    // Guardar la página en la BD
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|max:100',
            'description' => 'nullable|max:500',
        ]);

        // Generar un username único (slug + números aleatorios)
        $baseSlug = Str::slug($request->name);
        $username = $baseSlug . '-' . rand(1000, 9999);

        // Crear la página vinculada al usuario actual
        $page = Page::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'username' => $username,
            'category' => $request->category,
            'description' => $request->description,
            // Las fotos se quedan null por ahora (saldrá la bandera gris)
        ]);

        return redirect()->route('dashboard')->with('status', '¡Página creada exitosamente!');
    }

    /**
     * Muestra el Muro de la página (Inicio)
     */
    public function show($username)
    {
        // 1. Buscamos por username
        // 2. Cargamos posts con relaciones (autor, comentarios, reacciones) para evitar errores en la vista
        $page = Page::where('username', $username)
                    ->with(['posts.author', 'posts.comments', 'posts.reactions']) 
                    ->firstOrFail();

        // 3. Definimos la pestaña activa para el header
        $active = 'home';

        return view('pages.show', compact('page', 'active'));
    }

    /**
     * Muestra la sección Información
     */
    public function about($username)
    {
        $page = Page::where('username', $username)->firstOrFail();
        $active = 'about';

        return view('pages.about', compact('page', 'active'));
    }

    /**
     * Muestra la sección Fotos
     */
    public function photos($username)
    {
        // Necesitamos cargar 'posts' porque de ahí sacaremos las imágenes
        $page = Page::where('username', $username)
                    ->with('posts')
                    ->firstOrFail();
                    
        $active = 'photos';

        return view('pages.photos', compact('page', 'active'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $view = $request->get('view', 'discover'); // Por defecto 'discover'

        // 1. Mis Páginas (Siempre visibles en el sidebar)
        $myPages = \App\Models\Page::where('user_id', $user->id)->latest()->get();

        // 2. Lógica del Feed Principal (Liked vs Discover)
        $feedPages = collect(); // Colección vacía por defecto
        $title = '';

        if ($view === 'liked') {
            $title = 'Páginas que te gustan';
            // TODO: Cuando tengamos la tabla pivote 'page_user_likes', usaremos:
            // $feedPages = $user->likedPages()->get();
            // Por ahora, devolvemos vacío para no romper nada.
            $feedPages = collect(); 
        } else {
            $title = 'Descubrir páginas';
            // Todas las páginas MENOS las mías
            $feedPages = \App\Models\Page::where('user_id', '!=', $user->id)
                                ->latest()
                                ->get();
        }

        // 3. Invitaciones (Placeholder)
        $invitations = collect(); 

        return view('pages.index', compact('myPages', 'feedPages', 'invitations', 'view', 'title'));
    }

    // Asegúrate de importar Post y Page arriba
    // use App\Models\Post;
    // use App\Models\Page;

    public function storePost(Request $request, $username)
    {
        // Buscamos la página
        $page = Page::where('username', $username)->firstOrFail();

        // Seguridad: Solo el dueño publica (por ahora)
        if ($page->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para publicar en esta página.');
        }

        // 1. Validación
        $request->validate([
            'content' => 'required_without:image|nullable|string',
            'image'   => 'nullable|image|max:10240',
        ]);

        // 2. Lógica de Imagen (Igual que en perfil, pero carpeta distinta para orden)
        $attachments = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pages-posts', 'public');
            $attachments = [$path];
        }

        // 3. Crear el Post (Adaptando tu estructura para Páginas)
        \App\Models\Post::create([
            'user_id'     => auth()->id(),            // El usuario real detrás de la página
            'author_type' => \App\Models\Page::class, // <--- CAMBIO: El autor visual es la PÁGINA
            'author_id'   => $page->id,               // ID de la página
            
            // EL DESTINO: El muro de la propia página
            'wall_type'   => \App\Models\Page::class,
            'wall_id'     => $page->id,
            
            'content'     => $request->content,
            'attachments' => $attachments,
            'privacy'     => 'public',
        ]);

        return back();
    }
}