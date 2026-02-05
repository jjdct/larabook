<?php

namespace App\Traits;

use App\Models\Reaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait Reactable
{
    // Relación con la tabla reacciones
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    // Helper: ¿Está reaccionado por el usuario actual?
    public function isReactedBy(User $user = null)
    {
        $user = $user ?? Auth::user();
        return $this->reactions->where('user_id', $user->id)->first();
    }
    
    // Helper: Resumen de reacciones (para mostrar iconos)
    // Retorna array con los tipos únicos, ej: ['like', 'love']
    public function getReactionSummaryAttribute()
    {
        return $this->reactions->pluck('type')->unique()->take(3);
    }
}