<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str; // <--- Importante para normalizar texto

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden guardar masivamente.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'is_verified',
        'is_admin',
        'gender',
        'birthday',
        'pronoun',       
        'custom_gender', 
        'profile_photo', 
        'cover_photo',   
        'bio',           
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_admin' => 'boolean',
        ];
    }

    // ------------------------------------------------------------------------
    // ACCESORS (Lógica Visual)
    // ------------------------------------------------------------------------

    /**
     * 1. AVATAR: Siluetas de cuerpo completo (Estilo Pictograma)
     */
    public function getAvatarAttribute()
    {
        // A) Si el usuario subió foto real
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        // B) Configuración de Colores
        $bgColor = '#dfe3ee';   // Fondo gris Facebook
        $iconColor = '#8b9dc3'; // Silueta azul grisáceo (más elegante)
        
        $gender = \Illuminate\Support\Str::lower($this->gender);

        // --- HOMBRE (Silueta Normal / Pantalones) ---
        if ($gender === 'male' || $gender === 'hombre') {
            return "data:image/svg+xml;base64," . base64_encode('
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" style="background-color:'.$bgColor.';">
                    <circle cx="250" cy="110" r="60" fill="'.$iconColor.'"/>
                    <path fill="'.$iconColor.'" d="M160,200 h180 c20,0 40,20 40,40 v120 c0,10 -10,20 -20,20 h-20 v100 c0,10 -10,20 -20,20 h-40 c-10,0 -20,-10 -20,-20 v-90 h-20 v90 c0,10 -10,20 -20,20 h-40 c-10,0 -20,-10 -20,-20 v-100 h-20 c-10,0 -20,-10 -20,-20 v-120 c0,-20 20,-40 40,-40 z"/>
                </svg>');
        }

        // --- MUJER (Vestido Triangular) ---
        if ($gender === 'female' || $gender === 'mujer') {
            return "data:image/svg+xml;base64," . base64_encode('
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" style="background-color:'.$bgColor.';">
                    <circle cx="250" cy="110" r="60" fill="'.$iconColor.'"/>
                    <path fill="'.$iconColor.'" d="M250,190 L130,460 c-5,15 5,25 20,25 h200 c15,0 25,-10 20,-25 L250,190 z"/>
                </svg>');
        }

        // --- CUSTOM / OTRO (Robot 🤖) ---
        // Usamos un robot porque es neutro y genial para una red social hecha en Laravel
        return "data:image/svg+xml;base64," . base64_encode('
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" style="background-color:'.$bgColor.';">
                <rect x="140" y="140" width="220" height="180" rx="20" ry="20" fill="'.$iconColor.'"/>
                <circle cx="190" cy="210" r="25" fill="#fff"/>
                <circle cx="310" cy="210" r="25" fill="#fff"/>
                <rect x="190" y="270" width="120" height="20" rx="5" fill="#fff"/>
                <line x1="250" y1="140" x2="250" y2="80" stroke="'.$iconColor.'" stroke-width="15"/>
                <circle cx="250" cy="70" r="20" fill="'.$iconColor.'"/>
                <rect x="190" y="320" width="120" height="100" rx="20" fill="'.$iconColor.'"/>
            </svg>');
    }

    /**
     * 2. PORTADA DEFAULT
     */
    public function getCoverAttribute()
    {
        if ($this->cover_photo) {
            return asset('storage/' . $this->cover_photo);
        }

        return "data:image/svg+xml;base64," . base64_encode('
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none">
                <rect width="100%" height="100%" fill="#4b4f56"/>
            </svg>');
    }

    /**
     * 3. NOMBRE COMPLETO
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // ------------------------------------------------------------------------
    // RELACIONES
    // ------------------------------------------------------------------------

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    // Amigos donde YO envié la solicitud
    public function friendsOfMine()
    {
        return $this->belongsToMany(User::class, 'friendships', 'sender_id', 'receiver_id')
                    ->wherePivot('status', 'accepted');
    }

    // Amigos donde YO recibí la solicitud
    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friendships', 'receiver_id', 'sender_id')
                    ->wherePivot('status', 'accepted');
    }

    // Todos los amigos
    public function getFriendsAttribute()
    {
        return $this->friendsOfMine->merge($this->friendOf);
    }

    // Solicitudes Pendientes (Para notificaciones)
    public function pendingFriendRequests()
    {
        return $this->belongsToMany(User::class, 'friendships', 'receiver_id', 'sender_id')
                    ->wherePivot('status', 'pending');
    }

    // Helpers de Amistad
    public function isFriendWith(User $user)
    {
        return $this->friends->contains($user);
    }

    public function hasSentRequestTo(User $user)
    {
        return Friendship::where('sender_id', $this->id)
                         ->where('receiver_id', $user->id)
                         ->where('status', 'pending')
                         ->exists();
    }

    public function hasPendingRequestFrom(User $user)
    {
        return Friendship::where('sender_id', $user->id)
                         ->where('receiver_id', $this->id)
                         ->where('status', 'pending')
                         ->exists();
    }

    // ------------------------------------------------------------------------
    // RELACIONES DE POSTS (Muro y Autoría)
    // ------------------------------------------------------------------------

    // Posts que están EN MI MURO (escritos por mí o por otros)
    public function wallPosts()
    {
        return $this->morphMany(Post::class, 'wall')->latest();
    }

    // Posts que YO escribí (donde sea) - NECESARIO PARA ACTIVITY LOG
    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    // Comentarios que YO hice - NECESARIO PARA ACTIVITY LOG
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
    
    // Posts Guardados (Opcional, descomentar si existe la tabla pivote)
    /*
    public function savedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_saved', 'user_id', 'post_id')->withTimestamps();
    }
    */

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user')
                    ->withPivot('role', 'status')
                    ->withTimestamps();
    }
}