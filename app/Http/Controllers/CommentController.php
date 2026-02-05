<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PostInteracted;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Lógica de "Autoría" (Por ahora eres tú mismo, luego detectaremos si es Página)
        $authorType = \App\Models\User::class;
        $authorId = Auth::id();

        // Si vienes de una página (futuro selector):
        // if ($request->has('acting_as_page')) { ... }

        Comment::create([
            'user_id' => Auth::id(), // El humano
            'post_id' => $post->id,
            'author_type' => $authorType, // La máscara
            'author_id' => $authorId,
            'content' => $request->content,
        ]);
        // Evitar notificarse a uno mismo
        if ($post->user_id !== auth()->id()) {
            $post->author->notify(new PostInteracted(auth()->user(), $post, 'comment'));
        }

        return back();
    }

    public function destroy(Comment $comment)
    {
        // Solo el dueño del comentario o el dueño del post pueden borrar
        if (Auth::id() !== $comment->user_id && Auth::id() !== $comment->post->user_id) {
            abort(403);
        }

        $comment->delete();
        return back();
    }
}
