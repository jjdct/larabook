<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\LarabookResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\LarabookVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación: Un Usuario tiene muchos Posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
    * Enviar la notificación de reseteo de contraseña.
    *
    * @param  string  $token
    * @return void
    */
    public function sendPasswordResetNotification($token)
    {
        // Aquí le decimos que use NUESTRA clase
        $this->notify(new LarabookResetPassword($token));
    }

    // 1. Obtener todas las amistades donde soy el remitente o el receptor (solo aceptadas)
    public function friends()
    {
        // Amigos a los que yo les envié solicitud y aceptaron
        $friendsOfMine = $this->belongsToMany(User::class, 'friendships', 'sender_id', 'recipient_id')
            ->wherePivot('status', 'accepted');

        // Amigos que me enviaron solicitud y yo acepté
        $friendOf = $this->belongsToMany(User::class, 'friendships', 'recipient_id', 'sender_id')
            ->wherePivot('status', 'accepted');
            
        // Unir ambas listas (Laravel hace esto con merge, pero para Eloquent puro es un truco)
        // Por simplicidad en la vista, usaremos una colección combinada después.
        return $friendsOfMine->get()->merge($friendOf->get());    
    }

    // 2. Solicitudes pendientes que ME han enviado (para mostrar el numerito rojo)
    public function pendingFriendRequests()
    {
        return $this->belongsToMany(User::class, 'friendships', 'recipient_id', 'sender_id')
            ->wherePivot('status', 'pending');
    }

    // 3. Verificar si soy amigo de alguien (para mostrar el botón "Agregar" o "Amigos")
    public function isFriendWith($userId)
    {
        return Friendship::where('status', 'accepted')
            ->where(function($q) use ($userId) {
                $q->where(function($query) use ($userId) {
                    $query->where('sender_id', $this->id)->where('recipient_id', $userId);
                })->orWhere(function($query) use ($userId) {
                    $query->where('sender_id', $userId)->where('recipient_id', $this->id);
                });
            })->exists();
    }

    /**
     * Enviar la notificación de verificación de correo.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new LarabookVerifyEmail);
    }
}

