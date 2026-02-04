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

    // ACCESSOR: Portada por defecto (Un patrón geométrico simple en SVG)
    public function getCoverAttribute()
    {
        if ($this->attributes['cover_photo'] ?? null) {
            return asset('storage/' . $this->cover_photo);
        }

        // Generamos un patrón azulado estilo grupo
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
     * 3. AVATAR DE GRUPO (Para listas)
     * Reutilizamos la lógica de la portada pero para mostrar en miniatura.
     */
    public function getAvatarAttribute()
    {
        // Si tiene foto, la usa. Si no, usa el generador de patrones que ya hicimos.
        return $this->cover; 
    }
}