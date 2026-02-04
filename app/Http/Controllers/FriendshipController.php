<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    // 1. Enviar Solicitud (Add Friend)
    public function add(User $user)
    {
        // Evitar auto-agregarse
        if (Auth::id() === $user->id) {
            return back();
        }

        // Crear la relación pendiente
        Friendship::firstOrCreate([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id
        ]);

        return back()->with('status', 'Solicitud enviada');
    }

    // 2. Aceptar Solicitud (Confirm)
    public function accept(User $user)
    {
        $friendship = Friendship::where('sender_id', $user->id)
                                ->where('receiver_id', Auth::id())
                                ->first();

        if ($friendship) {
            $friendship->update(['status' => 'accepted']);
        }

        return back()->with('status', '¡Ahora son amigos!');
    }

    // 3. Rechazar o Cancelar Solicitud (Delete)
    // Sirve tanto para "Rechazar solicitud" como para "Cancelar envío"
    public function reject(User $user)
    {
        Friendship::where([
            ['sender_id', '=', Auth::id()],
            ['receiver_id', '=', $user->id]
        ])->orWhere([
            ['sender_id', '=', $user->id],
            ['receiver_id', '=', Auth::id()]
        ])->delete();

        return back()->with('status', 'Solicitud eliminada');
    }

    /**
     * Muestra la página principal de Amigos (/friends)
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Solicitudes que ME han enviado (y no he respondido)
        $requests = $user->pendingFriendRequests;

        // 2. Mis amigos actuales
        $friends = $user->friends;

        // 3. Sugerencias (Usuarios que NO son mis amigos ni tengo solicitudes con ellos)
        // Lógica simple: Traer todos menos yo, y filtrar en PHP (para no complicar la query SQL hoy)
        $suggestions = User::where('id', '!=', $user->id)->get()
            ->reject(function ($other) use ($user) {
                return $user->isFriendWith($other) || 
                       $user->hasSentRequestTo($other) || 
                       $user->hasPendingRequestFrom($other);
            })
            ->take(12); // Solo mostrar 12

        return view('friends.index', compact('requests', 'friends', 'suggestions'));
    }
}