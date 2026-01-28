<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'recipient_id', 'status'];

    // Relación con el que envía
    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relación con el que recibe
    public function recipient() {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}