<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class FriendRequestAccepted extends Notification
{
    use Queueable;

    public $accepter; // El usuario que aceptó (Yo, en este momento)

    public function __construct($accepter)
    {
        $this->accepter = $accepter;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            // Datos del actor (quien aceptó)
            'actor_id' => $this->accepter->id,
            'actor_name' => $this->accepter->name,
            'actor_avatar' => $this->accepter->avatar,
            
            // Datos del evento
            'type' => 'friend_accepted', // Tipo único para identificar el icono
            'message' => 'aceptó tu solicitud de amistad.',
            
            // A dónde te lleva si haces clic (al perfil del nuevo amigo)
            'link' => route('profile.show', $this->accepter->username),
        ];
    }
}