<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'recipient_id', 'body', 'read_at', 'archived_for_sender', 'archived_for_recipient', 'sender_id', 'sender_type', 'recipient_id', 'recipient_type'];

    // Relación Polimórfica: "El remitente puede ser cualquiera (User o Page)"
    public function sender()
    {
        return $this->morphTo();
    }

    // Relación Polimórfica: "El destinatario puede ser cualquiera"
    public function recipient()
    {
        return $this->morphTo();
    }
}