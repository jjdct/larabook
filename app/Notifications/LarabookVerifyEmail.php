<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class LarabookVerifyEmail extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // 1. Generamos la URL firmada (El truco mágico)
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        // 2. Enviamos nuestra vista bonita
        return (new MailMessage)
            ->subject('Confirma tu cuenta de Larabook')
            ->view('emails.verify', [
                'url' => $verificationUrl,
                'userName' => $notifiable->name,
                'userEmail' => $notifiable->email
            ]);
    }
}