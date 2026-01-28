<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Permitir guardar estos datos en masa
    protected $fillable = ['user_id', 'content'];

    // Relación: Un Post pertenece a un Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
