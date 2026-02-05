<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'username', // Es el "slug" único
        'category',
        'description',
        'location',
        'website',
        'avatar', // path de la foto
        'cover',  // path de la portada
        'is_verified'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES (Aquí estaba el error)
    |--------------------------------------------------------------------------
    */

    // 1. El dueño de la página (Admin)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 2. LOS POSTS DE LA PÁGINA (¡ESTO FALTABA!) 🚨
    // Usamos morphMany porque el Post se guarda como wall_type = 'App\Models\Page'
    public function posts()
    {
        return $this->morphMany(Post::class, 'wall')->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS (Lógica Visual)
    |--------------------------------------------------------------------------
    */

    // Avatar por defecto (Icono de Bandera 🏳️)
    public function getAvatarAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        }

        // Icono de bandera svg generado al vuelo
        $color = '#dfe3ee';
        $iconColor = '#fff';
        
        return "data:image/svg+xml;base64," . base64_encode('
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" style="background-color:'.$color.';">
                <path fill="'.$iconColor.'" d="M160,80 h20 v360 h-20 z M180,80 h220 l-60,100 l60,100 h-220 z"/>
            </svg>');
    }

    // Portada por defecto (Gris)
    public function getCoverAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        }

        return "data:image/svg+xml;base64," . base64_encode('
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none">
                <rect width="100%" height="100%" fill="#4b4f56"/>
            </svg>');
    }
    
    // Helper: Usar 'slug' o 'username' indistintamente en rutas
    public function getSlugAttribute()
    {
        return $this->username;
    }
}