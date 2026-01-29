<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\LarabookVerifyEmail; 

class User extends Authenticatable
{
    // HE QUITADO 'HasApiTokens' DE AQUÍ ABAJO 👇
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- LÓGICA DE AMIGOS ---

    // 1. Solicitudes PENDIENTES (Devuelve Friendships)
    public function pendingFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'recipient_id')
                    ->where('status', 'pending');
    }

    // 2. ¿Somos amigos? (Para botones)
    public function isFriendWith($userId)
    {
        return $this->friends()->contains('id', $userId);
    }

    // 3. Obtener TODOS los amigos
    public function friends()
    {
        $friendsOfMine = $this->belongsToMany(User::class, 'friendships', 'sender_id', 'recipient_id')
            ->wherePivot('status', 'accepted');

        $friendOf = $this->belongsToMany(User::class, 'friendships', 'recipient_id', 'sender_id')
            ->wherePivot('status', 'accepted');

        return $friendsOfMine->get()->merge($friendOf->get());
    }

    // 4. Email bonito
    public function sendEmailVerificationNotification()
    {
        $this->notify(new LarabookVerifyEmail);
    }

    // --- LÓGICA DEL MURO ---

    // Relación: Un usuario tiene muchas publicaciones
    public function posts()
    {
        return $this->hasMany(Post::class)->latest(); 
    }

    // --- NUEVAS FUNCIONES DE AYUDA ---

    // 1. ¿Yo le envié solicitud a este usuario? (Para mostrar "Solicitud enviada")
    public function hasSentRequestTo(User $user)
    {
        return Friendship::where('sender_id', $this->id)
                         ->where('recipient_id', $user->id)
                         ->where('status', 'pending')
                         ->exists();
    }

    // 2. ¿Este usuario me envió solicitud a mí? (Para mostrar "Aceptar/Rechazar")
    public function hasReceivedRequestFrom(User $user)
    {
        return Friendship::where('sender_id', $user->id)
                         ->where('recipient_id', $this->id)
                         ->where('status', 'pending')
                         ->exists();
    }
}