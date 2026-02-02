<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginAlert extends Mailable
{
    use Queueable, SerializesModels;

    // Pasamos datos falsos por defecto para probar en Tinker
    public function __construct(
        public User $user,
        public string $browser = 'Chrome en Windows',
        public string $location = 'Ciudad de México, México',
        public string $ip = '192.168.1.1'
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Alerta de inicio de sesión');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-login');
    }
}