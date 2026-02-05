<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Reactable;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Reactable;

    protected $guarded = [];

    // Relaciones
    public function user() { return $this->belongsTo(User::class); }
    public function post() { return $this->belongsTo(Post::class); }
    public function author() { return $this->morphTo(); }
}