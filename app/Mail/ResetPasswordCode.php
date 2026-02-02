<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordCode extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $url = '#') {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Restablece tu contraseña');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.reset-password');
    }
}