<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'about', 'category', 'user_id'];

    // El creador de la página
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Los fans (Gente que le dio Like)
    public function fans()
    {
        return $this->belongsToMany(User::class, 'page_user')->withTimestamps();
    }
}