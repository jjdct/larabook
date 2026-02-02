<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'gender',
        'birthday',
        'pronoun',       // Nuevo
        'custom_gender', // Nuevo
        'profile_photo', // Nuevo
        'cover_photo',   // Nuevo
        'bio',           // Nuevo
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
        ];
    }

    // ------------------------------------------------------------------------
    // ACCESORS (Lógica Anti-Errores)
    // ------------------------------------------------------------------------

    /**
     * 1. AVATAR: Si no hay foto, genera el SVG clásico según el sexo.
     */
    public function getAvatarAttribute()
    {
        // A) Si el usuario subió foto, devolvemos la ruta (asumiendo storage público)
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        // B) Si no hay foto, generamos la silueta por defecto (SVG)
        $color = '#dfe3ee'; // Gris azulado Facebook
        $iconColor = '#fff'; 
        
        // Silueta Hombre
        if ($this->gender === 'male') {
            return "data:image/svg+xml;base64," . base64_encode('
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" style="background-color:'.$color.';">
                    <path fill="'.$iconColor.'" d="M250,260.9c48.8,0,88.4-39.6,88.4-88.4S298.8,84.1,250,84.1s-88.4,39.6-88.4,88.4S201.2,260.9,250,260.9z M250,296.2c-68,0-204,34-204,102v33.7h408v-33.7C454,330.2,318,296.2,250,296.2z"/>
                </svg>');
        }

        // Silueta Mujer
        if ($this->gender === 'female') {
            return "data:image/svg+xml;base64," . base64_encode('
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" style="background-color:'.$color.';">
                    <path fill="'.$iconColor.'" d="M250,84.1c-48.8,0-88.4,39.6-88.4,88.4c0,37.3,23.3,69.1,55.8,82.1c-17,16.8-27.4,40.1-27.4,66.3H310c0-26.2-10.4-49.5-27.4-66.3c32.5-13,55.8-44.8,55.8-82.1C338.4,123.7,298.8,84.1,250,84.1z M250,346.2c-68,0-204,34-204,102v33.7h408v-33.7C454,380.2,318,346.2,250,346.2z"/>
                </svg>');
        }

        // Silueta Neutra (Para custom o errores)
        return "data:image/svg+xml;base64," . base64_encode('
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" style="background-color:'.$color.';">
                <circle cx="250" cy="180" r="90" fill="'.$iconColor.'"/>
                <path fill="'.$iconColor.'" d="M250,300c-70,0-210,40-210,120v40h420v-40C460,340,320,300,250,300z"/>
            </svg>');
    }

    /**
     * 2. PORTADA: Si no hay portada, devuelve un color gris oscuro por defecto.
     */
    public function getCoverAttribute()
    {
        if ($this->cover_photo) {
            return asset('storage/' . $this->cover_photo);
        }

        // Retornamos una imagen de 1x1 pixel gris oscuro (o un patrón SVG simple)
        return "data:image/svg+xml;base64," . base64_encode('
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none">
                <rect width="100%" height="100%" fill="#4b4f56"/>
            </svg>');
    }

    /**
     * 3. NOMBRE COMPLETO: Virtual attribute
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function sendEmailVerificationNotification()
    {
        // Usamos la ruta completa con \ para evitar errores de importación
        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            \Illuminate\Support\Carbon::now()->addMinutes(\Illuminate\Support\Facades\Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );

        // Enviar NUESTRO correo
        \Illuminate\Support\Facades\Mail::to($this)->send(new \App\Mail\VerifyEmail($this, $url));
    }
}