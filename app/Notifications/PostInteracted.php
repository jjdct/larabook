<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue; // Opcional: para que no sea lento
use Illuminate\Notifications\Messages\DatabaseMessage; // Usaremos Database, no Mail

class PostInteracted extends Notification
{
    use Queueable;

    public $actor; // Quién hizo la acción (Miku)
    public $post;  // En qué post
    public $type;  // 'like' o 'comment'

    public function __construct($actor, $post, $type)
    {
        $this->actor = $actor;
        $this->post = $post;
        $this->type = $type;
    }

    // Definimos canales: Solo base de datos por ahora
    public function via($notifiable)
    {
        return ['database'];
    }

    // Estructura de datos que se guardará en la tabla
    public function toDatabase($notifiable)
    {
        return [
            'actor_id' => $this->actor->id,
            'actor_name' => $this->actor->name,
            'actor_avatar' => $this->actor->avatar,
            'post_id' => $this->post->id,
            'post_content' => \Illuminate\Support\Str::limit($this->post->content, 20), // Resumen
            'type' => $this->type, // 'like' o 'comment'
            'message' => $this->type === 'like' 
                ? 'reaccionó a tu publicación.' 
                : 'comentó tu publicación.',
            'link' => route('post.show', $this->post->id), // Link directo
        ];
    }
}