<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show(\App\Models\Post $post)
    {
        // Cargamos las relaciones para que no falle la vista
        $post->load(['author', 'comments.author', 'reactions']);
        
        return view('posts.show', compact('post'));
    }

    // Borrar Post
    public function destroy(Post $post)
    {
        // Seguridad: Solo el dueño del post o el dueño del muro pueden borrar
        if (Auth::id() !== $post->user_id && Auth::id() !== $post->wall_id) {
            abort(403, 'No tienes permiso para borrar esto.');
        }

        $post->delete();
        return back()->with('status', 'Publicación eliminada.');
    }

    // Guardar Post (Toggle)
    public function toggleSave(Post $post)
    {
        // Nota: Necesitamos una relación 'savedPosts' en el modelo User
        Auth::user()->savedPosts()->toggle($post->id);
        return back();
    }

    // Agrega esto a tu PostController

    public function share(Request $request, \App\Models\Post $post)
    {
        $request->validate([
            'content' => 'nullable|string',
            'destination' => 'required|in:profile,group,page', // Dónde lo quieres compartir
            'destination_id' => 'nullable|integer' // ID del grupo o página
        ]);

        // 1. Definir el Muro de destino
        $wallType = \App\Models\User::class;
        $wallId = auth()->id(); // Por defecto: Mi perfil

        if ($request->destination === 'group') {
            $wallType = \App\Models\Group::class;
            $wallId = $request->destination_id;
        } elseif ($request->destination === 'page') {
            $wallType = \App\Models\Page::class;
            $wallId = $request->destination_id;
        }

        // 2. Crear el contenido compartido
        // (En una app real tendrías una columna 'shared_post_id', pero aquí lo simulamos agregando el link al final)
        $shareContent = $request->content . "\n\n🔄 Compartido de una publicación de " . $post->author->name . ":\n" . route('post.show', $post);

        // 3. Crear el nuevo Post
        \App\Models\Post::create([
            'user_id'     => auth()->id(),
            'author_type' => \App\Models\User::class,
            'author_id'   => auth()->id(),
            'wall_type'   => $wallType,
            'wall_id'     => $wallId,
            'content'     => $shareContent,
            'privacy'     => 'public',
        ]);

        return back()->with('status', '¡Publicación compartida con éxito!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required_without:image|nullable|string',
            'image'   => 'nullable|image|max:10240',
        ]);

        $attachments = null;
        if ($request->hasFile('image')) {
            // Guardamos en la carpeta 'posts' del disco público
            $path = $request->file('image')->store('posts', 'public');
            $attachments = [$path];
        }

        \App\Models\Post::create([
            'user_id'     => auth()->id(),
            'author_type' => \App\Models\User::class,
            'author_id'   => auth()->id(),
            
            // Wall Type = User (Muro personal)
            'wall_type'   => \App\Models\User::class,
            'wall_id'     => auth()->id(),
            
            'content'     => $request->content,
            'attachments' => $attachments,
            'privacy'     => 'public',
        ]);

        return back();
    }
}