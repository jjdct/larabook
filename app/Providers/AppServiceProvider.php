<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // VIEW COMPOSER: Compartir datos con TODAS las vistas (*)
        View::composer('*', function ($view) {
            
            // Solo si el usuario está logueado
            if (Auth::check()) {
                
                // 1. Amigos conectados (Sidebar derecha)
                $friends = Auth::user()->friends();

                // 2. Mini Chat (Última conversación)
                $lastMessage = Message::where('sender_id', Auth::id())
                    ->orWhere('recipient_id', Auth::id())
                    ->latest()
                    ->first();

                $activeChatUser = null;
                $activeChatMessages = collect();

                if ($lastMessage) {
                    $otherUserId = $lastMessage->sender_id === Auth::id() 
                        ? $lastMessage->recipient_id 
                        : $lastMessage->sender_id;
                    
                    $activeChatUser = User::find($otherUserId);

                    if ($activeChatUser) {
                        $activeChatMessages = Message::where(function($q) use ($activeChatUser) {
                            $q->where('sender_id', Auth::id())->where('recipient_id', $activeChatUser->id);
                        })->orWhere(function($q) use ($activeChatUser) {
                            $q->where('sender_id', $activeChatUser->id)->where('recipient_id', Auth::id());
                        })
                        ->latest()
                        ->take(5)
                        ->get()
                        ->reverse();
                    }
                }

                // Inyectamos las variables con un prefijo 'global' para no chocar con las locales
                $view->with('globalFriends', $friends)
                     ->with('globalActiveChatUser', $activeChatUser)
                     ->with('globalActiveChatMessages', $activeChatMessages);
            }
        });
    }
}
