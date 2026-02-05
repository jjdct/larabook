<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Reactable;

class Post extends Model
{
    use HasFactory, SoftDeletes, Reactable;

    protected $guarded = [];

    // CASTING: Convertimos el JSON de la BD a Array de PHP automáticamente
    protected $casts = [
        'attachments' => 'array', // ['foto1.jpg', 'video.mp4']
        'is_ad' => 'boolean',
        'published_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // 1. El Humano Real (Siempre necesario para bans/logs)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 2. La "Identidad Visual" (¿Quién aparece como autor?)
    // Retorna User o Page
    public function author()
    {
        return $this->morphTo();
    }

    // 3. El Destino (¿Dónde vive este post?)
    // Retorna User, Page o Group
    public function wall()
    {
        return $this->morphTo();
    }
    
    // Relación con comentarios (La crearemos pronto)
    // public function comments() { return $this->hasMany(Comment::class); }

    /*
    |--------------------------------------------------------------------------
    | HELPERS VISUALES (Para facilitar la vida en Blade)
    |--------------------------------------------------------------------------
    */

    // ¿Es un post en un grupo?
    public function isGroupPost()
    {
        return $this->wall_type === 'App\Models\Group';
    }

    // ¿Es un post en una página?
    public function isPagePost()
    {
        return $this->wall_type === 'App\Models\Page';
    }
    
    // Obtener el nombre del autor visual
    public function getAuthorNameAttribute()
    {
        // Si el autor soy yo mismo (User), devuelvo mi nombre
        // Si es una Página, devuelvo el nombre de la página
        return $this->author->name ?? 'Usuario Desconocido';
    }

    // Obtener el avatar del autor visual
    public function getAuthorAvatarAttribute()
    {
        return $this->author->avatar ?? 'https://ui-avatars.com/api/?name=X';
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}