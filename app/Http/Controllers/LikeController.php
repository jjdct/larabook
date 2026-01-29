<?php

namespace App\Models; // OJO: Esto puede estar mal en el copy-paste, revisa namespace
namespace App\Http\Controllers; // CORRECTO

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Por ahora solo soportamos Posts para simplificar
    public function togglePost(Post $post)
    {
        $existingLike = $post->likes()->where('user_id', Auth::id())->first();

        if ($existingLike) {
            $existingLike->delete(); // Quitar like
        } else {
            $post->likes()->create([
                'user_id' => Auth::id()
            ]);
        }

        return back();
    }
}
