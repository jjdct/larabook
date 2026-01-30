<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // AÑADIR 'image_path' AQUÍ 👇
    protected $fillable = ['user_id', 'content', 'image_path', 'page_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // ... el resto de tus relaciones (likes, comments) ...
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Relación con la Página (NUEVA)
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}