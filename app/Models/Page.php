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
        'username',
        'category',
        'profile_photo',
        'cover_photo',
        'description',
        'website',
        'location',
        'is_verified',
        'is_published',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_published' => 'boolean',
    ];

    // Relación: Una página pertenece a un Creador/Admin
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function show($username)
    {
        // Busca la página. Si no existe, lanza error 404 automáticamente.
        $page = Page::where('username', $username)->firstOrFail();

        return view('pages.show', compact('page'));
    }

    // ------------------------------------------------------------------------
    // ACCESORS (Lógica Visual)
    // ------------------------------------------------------------------------

    /**
     * 1. AVATAR DE PÁGINA
     * Si no hay foto, generamos la "Bandera Gris" clásica de las Fan Pages.
     */
    public function getAvatarAttribute()
    {
        // A) Si tiene foto subida, la devolvemos
        if ($this->attributes['profile_photo'] ?? null) {
            return asset('storage/' . $this->profile_photo);
        }

        // B) Si no, generamos el SVG de la Bandera
        $bgColor = '#dfe3ee'; // El mismo gris azulado
        $iconColor = '#ffffff'; // Blanco para la figura

        // Este SVG dibuja una bandera simple en el centro
        $svg = '
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" style="background-color:'.$bgColor.';">
            <rect x="130" y="80" width="30" height="340" rx="5" fill="'.$iconColor.'"/>
            <path fill="'.$iconColor.'" d="M160,100 H380 L340,190 L380,280 H160 V100 Z"/>
        </svg>';

        return "data:image/svg+xml;base64," . base64_encode($svg);
    }

    /**
     * 2. PORTADA DE PÁGINA
     * Igual que el usuario, un fondo gris oscuro neutro.
     */
    public function getCoverAttribute()
    {
        if ($this->attributes['cover_photo'] ?? null) {
            return asset('storage/' . $this->cover_photo);
        }

        // Fondo gris oscuro plano (#4b4f56)
        $svg = '
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none">
            <rect width="100%" height="100%" fill="#4b4f56"/>
        </svg>';

        return "data:image/svg+xml;base64," . base64_encode($svg);
    }
}