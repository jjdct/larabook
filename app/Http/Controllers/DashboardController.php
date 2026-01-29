<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. PUBLICACIONES: Obtener las del muro (ordenadas por fecha)
        // (En el futuro aquí filtraríamos solo las de amigos, por ahora todas)
        $posts = Post::with('user')->latest()->get();

        // 2. AMIGOS: Para la barra lateral derecha
        // Usamos la relación 'friends' que creamos en User.php
        $friends = Auth::user()->friends();

        // 3. MINI CHAT: Buscar la última conversación activa
        // Buscamos el último mensaje donde yo participé
        $lastMessage = Message::where('sender_id', Auth::id())
            ->orWhere('recipient_id', Auth::id())
            ->latest()
            ->first();

        $activeChatUser = null;
        $activeChatMessages = collect(); // Colección vacía por defecto

        if ($lastMessage) {
            // Identificar quién es la "otra persona"
            $otherUserId = $lastMessage->sender_id === Auth::id() 
                ? $lastMessage->recipient_id 
                : $lastMessage->sender_id;
            
            $activeChatUser = User::find($otherUserId);

            // Si el usuario existe, traemos los últimos 5 mensajes
            if ($activeChatUser) {
                $activeChatMessages = Message::where(function($q) use ($activeChatUser) {
                    $q->where('sender_id', Auth::id())->where('recipient_id', $activeChatUser->id);
                })->orWhere(function($q) use ($activeChatUser) {
                    $q->where('sender_id', $activeChatUser->id)->where('recipient_id', Auth::id());
                })
                ->latest() // Primero los nuevos para tomar solo 5
                ->take(5)
                ->get()
                ->reverse(); // Les damos la vuelta para mostrarlos cronológicamente (viejo arriba, nuevo abajo)
            }
        }

        // Enviamos todo a la vista 'dashboard'
        return view('dashboard', compact('posts', 'friends', 'activeChatUser', 'activeChatMessages'));
    }
}
