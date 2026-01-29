<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function sendRequest(User $user)
    {
        $currentUser = Auth::user();

        // 1. Evitar enviarse solicitud a uno mismo
        if ($currentUser->id === $user->id) {
            return back()->with('error', 'No puedes enviarte solicitud a ti mismo.');
        }

        // 2. Verificar si ya existe una relación (pendiente o aceptada)
        // Buscamos si existe A->B o B->A
        $exists = Friendship::where(function($q) use ($currentUser, $user) {
            $q->where('sender_id', $currentUser->id)->where('recipient_id', $user->id);
        })->orWhere(function($q) use ($currentUser, $user) {
            $q->where('sender_id', $user->id)->where('recipient_id', $currentUser->id);
        })->exists();

        if ($exists) {
            return back()->with('error', 'Ya existe una solicitud o amistad con este usuario.');
        }

        // 3. Crear la solicitud
        Friendship::create([
            'sender_id' => $currentUser->id,
            'recipient_id' => $user->id,
            'status' => 'pending' // Por defecto es pending, pero lo explícito es mejor
        ]);

        // 4. Redirigir con mensaje de éxito
        return back()->with('success', '¡Solicitud de amistad enviada a ' . $user->name . '!');
    }

    // 1. Ver la lista de solicitudes pendientes
    public function index()
    {
        // Usamos el método mágico que creamos en User.php
        $requests = Auth::user()->pendingFriendRequests()->with('sender')->get();
        return view('friends.index', compact('requests'));
    }

    // 2. Aceptar solicitud
    public function accept(User $sender)
    {
        $recipient = Auth::user();

        // Buscar la solicitud exacta
        $friendship = Friendship::where('sender_id', $sender->id)
            ->where('recipient_id', $recipient->id)
            ->where('status', 'pending')
            ->firstOrFail();

        // Actualizar a aceptado
        $friendship->update(['status' => 'accepted']);

        return back()->with('success', '¡Ahora eres amigo de ' . $sender->name . '!');
    }

    // 3. Rechazar (Eliminar) solicitud
    public function reject(User $sender)
    {
        $recipient = Auth::user();

        Friendship::where('sender_id', $sender->id)
            ->where('recipient_id', $recipient->id)
            ->delete();

        return back()->with('success', 'Solicitud eliminada.');
    }
}