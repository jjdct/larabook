<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Mostrar formulario de crear página
    public function create()
    {
        return view('pages.create');
    }

    // Guardar la página en la DB
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required',
            'about' => 'nullable|max:500',
        ]);

        // Crear el slug (URL amigable)
        $slug = Str::slug($request->name);
        
        // Asegurar que el slug sea único (si existe "tacos", usar "tacos-1")
        $count = Page::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $page = Page::create([
            'user_id' => Auth::id(), // El creador es el dueño
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
            'about' => $request->about,
        ]);

        // Auto-Like: El creador es el primer fan
        $page->fans()->attach(Auth::id());

        return redirect()->route('pages.show', $page->slug);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        
        // ¿El usuario actual es fan?
        $isFan = Auth::check() ? $page->fans->contains(Auth::id()) : false;

        // OBTENER POSTS DE LA PÁGINA
        // Por ahora enviamos una colección vacía para que no falle la vista.
        // (Más adelante haremos que las páginas puedan tener sus propios posts)
        // AHORA: Buscamos los posts que pertenecen a ESTA página
        $posts = Post::where('page_id', $page->id)
                     ->with(['user', 'page', 'likes', 'comments']) // Carga rápida
                     ->latest()
                     ->get();

        return view('pages.show', compact('page', 'isFan', 'posts'));
    }

    // IMPORTANTE: Asegúrate de importar Message arriba: 
    // use App\Models\Message;

    public function inbox($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        // SEGURIDAD: Solo el dueño de la página puede ver el inbox
        if (Auth::id() !== $page->user_id) {
            abort(403, 'No tienes permiso para ver los mensajes de esta página.');
        }

        // Obtener mensajes donde el RECEPTOR es esta página
        // Agrupamos por el usuario que envió el mensaje para hacer una lista de conversaciones
        $conversations = Message::where('recipient_type', 'App\Models\Page')
                                ->where('recipient_id', $page->id)
                                ->with('sender') // Cargamos quién lo envió
                                ->get()
                                ->unique('sender_id'); // Para no repetir al mismo usuario 50 veces

        return view('pages.inbox', compact('page', 'conversations'));
    }

    // MOSTRAR EL PANEL DE ADMIN (EDITAR)
    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        // SEGURIDAD: Solo el dueño pasa
        if (Auth::id() !== $page->user_id) {
            abort(403);
        }

        return view('pages.edit', compact('page'));
    }

    // GUARDAR LOS CAMBIOS
    public function update(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        if (Auth::id() !== $page->user_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'nullable|string|max:1000',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048' // Validación de imagen
        ]);

        $page->name = $request->name;
        $page->about = $request->about;
        $page->category = $request->category;

        // Subir nueva foto de perfil de la página?
        /* NOTA: Para que esto funcione, asegúrate de tener el 
           enlace simbólico creado con: php artisan storage:link 
        */
        /*
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pages', 'public');
            $page->image_path = $path; // Asegúrate de tener esta columna en la DB o usa ui-avatars
        }
        */

        $page->save();

        return redirect()->route('pages.show', $page->slug)->with('status', 'Página actualizada');
    }
}
