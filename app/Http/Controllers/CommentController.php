<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function storePost(Request $request, Post $post)
    {
        $request->validate(['body' => 'required']);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);

        return back();
    }
}