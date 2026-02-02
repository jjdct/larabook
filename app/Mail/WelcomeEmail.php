<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {} // Recibimos el usuario

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Bienvenido a Larabook');
    }

    public function content(): Content
    {
        // Asegúrate de que tu vista se llame así en resources/views/emails/
        return new Content(view: 'emails.welcome-email');
    }
}