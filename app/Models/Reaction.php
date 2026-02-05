<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    // ✅ AGREGA ESTO PARA SOLUCIONAR EL ERROR
    protected $fillable = [
        'user_id', 
        'reactable_id', 
        'reactable_type', 
        'type'
    ];

    // Relación polimórfica
    public function reactable()
    {
        return $this->morphTo();
    }

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
