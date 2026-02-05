<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'privacy', 'cover_photo'
    ];

    // RELACIÓN: Un grupo tiene muchos miembros (Usuarios)
    public function members()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('role', 'status')
                    ->withTimestamps();
    }

    // RELACIÓN: El creador original
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // RELACIÓN: Posts del grupo (¡NUEVO E INDISPENSABLE!)
    public function posts()
    {
        return $this->morphMany(Post::class, 'wall');
    }

    // ACCESSOR: Portada por defecto (Patrón geométrico)
    public function getCoverAttribute()
    {
        if ($this->attributes['cover_photo'] ?? null) {
            return asset('storage/' . $this->cover_photo);
        }

        // Patrón azulado
        $svg = '
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#3b5998" stroke-width="1" opacity="0.2"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="#e9ebee"/>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>';

        return "data:image/svg+xml;base64," . base64_encode($svg);
    }

     /**
     * ACCESSOR: Avatar de Grupo (Icono de personas)
     */
    public function getAvatarAttribute()
    {
        // Si hay portada personalizada, usémosla como avatar también por ahora (o podrías agregar columna 'avatar')
        if ($this->attributes['cover_photo'] ?? null) {
            return asset('storage/' . $this->cover_photo);
        }

        // Generamos un icono de "Grupo de personas" en SVG para que se vea diferente a la portada
        $color = '#1877f2'; // Azul Facebook
        $bg = '#e7f3ff';    // Azul claro
        
        $svg = '
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" style="background-color:'.$bg.';">
            <circle cx="250" cy="220" r="80" fill="'.$color.'"/>
            <path fill="'.$color.'" d="M250,320 c-60,0 -110,40 -110,100 v20 h220 v-20 c0,-60 -50,-100 -110,-100 z"/>
            <circle cx="380" cy="250" r="60" fill="'.$color.'" opacity="0.7"/>
            <circle cx="120" cy="250" r="60" fill="'.$color.'" opacity="0.7"/>
        </svg>';

        return "data:image/svg+xml;base64," . base64_encode($svg);
    }
}