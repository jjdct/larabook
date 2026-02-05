<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PostInteracted;

class ReactionController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'reactable_id' => 'required|integer',
            'reactable_type' => 'required|string', // App\Models\Post o App\Models\Comment
            'type' => 'required|in:like,love,haha,wow,sad,angry',
        ]);

        $user = Auth::user();
        
        // Buscar si ya existe una reacción de este usuario a este item
        $existingReaction = Reaction::where('user_id', $user->id)
            ->where('reactable_id', $request->reactable_id)
            ->where('reactable_type', $request->reactable_type)
            ->first();

        if ($existingReaction) {
            if ($existingReaction->type === $request->type) {
                // Si es la misma, la quitamos (Toggle Off)
                $existingReaction->delete();
            } else {
                // Si es diferente, la actualizamos (De Like a Love)
                $existingReaction->update(['type' => $request->type]);
            }
        } else {
            // Si no existe, la creamos
            Reaction::create([
                'user_id' => $user->id,
                'reactable_id' => $request->reactable_id,
                'reactable_type' => $request->reactable_type, // Ojo con el namespace completo
                'type' => $request->type,
            ]);
        } // Evitar notificarse a uno mismo
            if ($post->user_id !== auth()->id()) {
            $post->author->notify(new PostInteracted(auth()->user(), $post, 'like'));
            }

        return back();
    }
}