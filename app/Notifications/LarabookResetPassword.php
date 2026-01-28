<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LarabookResetPassword extends Notification
{
    use Queueable;

    public $token;

    // Recibimos el token al crear la notificación
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Generamos el enlace exacto para resetear (igual que Laravel)
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Usamos nuestra vista 'emails.reset'
        return (new MailMessage)
            ->subject('Restablecer contraseña de Larabook')
            ->view('emails.reset', [
                'actionUrl' => $url,
                'countName' => $notifiable->name,
                'email' => $notifiable->email
            ]);
    }
}