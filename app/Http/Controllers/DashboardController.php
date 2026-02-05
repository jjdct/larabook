<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Group;
use App\Models\Page;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. RECOLECTAR IDs DE INTERÉS
        
        // Mis Grupos (IDs de los grupos donde soy miembro)
        // Asegúrate de tener la relación groups() en User, si no, usa la tabla pivote manualmente.
        $myGroupIds = $user->groups()->pluck('groups.id'); 

        // Mis Páginas (IDs de páginas que administro)
        $myPageIds = Page::where('user_id', $user->id)->pluck('id');
        
        // Paginas que sigo (Futuro: $user->likedPages()->pluck('id'))
        $followingPageIds = collect(); 

        // Mis Amigos (Futuro: $user->friends()->pluck('id'))
        $friendIds = collect(); 

        // 2. SUPER QUERY DEL FEED
        // "Trae posts donde..."
        $posts = Post::with(['author', 'wall', 'comments', 'reactions'])
            ->where(function($query) use ($user, $myGroupIds, $myPageIds) {
                
                // A) Lo escribí yo
                $query->where('user_id', $user->id)
                
                // B) Es de un Grupo al que pertenezco
                ->orWhere(function($q) use ($myGroupIds) {
                    $q->where('wall_type', Group::class)
                      ->whereIn('wall_id', $myGroupIds);
                })
                
                // C) Es de una Página que administro (o sigo)
                ->orWhere(function($q) use ($myPageIds) {
                    $q->where('wall_type', Page::class)
                      ->whereIn('wall_id', $myPageIds);
                });
                
                // D) Es de un amigo (Futuro)
                // ->orWhereIn('user_id', $friendIds);
            })
            ->latest() // Lo más nuevo primero
            ->paginate(20);

        // 3. CONTACTOS (Sidebar Derecho)
        // Por ahora vacío hasta tener sistema de amigos
        $contacts = collect(); 

        return view('dashboard', compact('posts', 'contacts'));
    }
}