<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // GUARDAR POST (Ahora con imagen)
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string', // Ahora puede ser null si subes solo foto
            'image' => 'nullable|image|max:2048', // Máximo 2MB
            'page_id' => 'nullable|exists:pages,id', // <--- Validación nueva. para paginas
        ]);

        // Si no hay texto ni imagen, error
        if (!$request->content && !$request->hasFile('image')) {
            return back()->withErrors(['content' => 'Escribe algo o sube una foto.']);
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;

        // Si enviamos un ID de página, lo guardamos
        if ($request->has('page_id')) {
            // AQUÍ PODRÍAS VALIDAR SI EL USUARIO ES ADMIN DE LA PÁGINA
            $post->page_id = $request->input('page_id');
        }

        // Manejo de la imagen
        if ($request->hasFile('image')) {
            // Se guarda en storage/app/public/posts
            $path = $request->file('image')->store('posts', 'public');
            $post->image_path = $path;
        }

        $post->save();

        return back();
    }

    // MOSTRAR UN SOLO POST (Permalink)
    public function show(Post $post)
    {
        // Cargamos relaciones para optimizar
        $post->load(['user', 'comments.user', 'likes']);
        
        return view('posts.show', compact('post'));
    }
}