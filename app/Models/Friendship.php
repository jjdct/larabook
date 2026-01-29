<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    // Permitimos rellenar estos campos masivamente
    protected $fillable = ['sender_id', 'recipient_id', 'status'];

    /**
     * Relación: Quién envió la solicitud.
     * Laravel conectará 'sender_id' con la tabla 'users'.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relación: Quién recibe la solicitud.
     * Laravel conectará 'recipient_id' con la tabla 'users'.
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}