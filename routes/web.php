<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

// 1. RUTA PARA VER EL MURO (Dashboard)
Route::get('/dashboard', function () {
    // Obtener todos los posts, ordenados del más nuevo al más viejo
    // 'user' sirve para cargar el nombre del autor de golpe y que sea rápido
    $posts = Post::with('user')->latest()->get(); 
    
    return view('dashboard', ['posts' => $posts]);
})->middleware(['auth', 'verified'])->name('dashboard');

// 2. RUTA PARA PUBLICAR (Guardar en BD)
Route::post('/posts', function (Request $request) {
    // Validar que no envíen cosas vacías
    $request->validate([
        'content' => 'required|max:255',
    ]);

    // Crear el post
    Post::create([
        'user_id' => auth()->id(), // El ID del usuario conectado
        'content' => $request->input('content'),
    ]);

    // Recargar la página
    return back();
})->middleware(['auth'])->name('posts.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// RUTA DE PERFIL PÚBLICO
// {user} es un "comodín". Laravel buscará automáticamente al usuario por su ID.
Route::get('/user/{user}', function (App\Models\User $user) {
    
    // Cargar los posts SOLO de este usuario
    $posts = $user->posts()->latest()->get();
    
    return view('profile.show', [
        'user' => $user,
        'posts' => $posts
    ]);
})->name('users.show');

// RUTA PARA JUEGOS (CANVAS)
Route::get('/games', function () {
    return view('games.index');
})->middleware(['auth'])->name('games');

// RUTA PARA MENSAJES (INBOX COMPLETO)
Route::get('/messages', function () {
    return view('messages.index');
})->middleware(['auth'])->name('messages.index');

Route::get('/seguridad-extrema', function () {
    return "¡Si ves esto es que confirmaste tu contraseña!";
})->middleware(['auth', 'password.confirm']);

Route::middleware(['auth'])->group(function () {
    Route::post('/add-friend/{user}', [FriendshipController::class, 'sendRequest'])->name('friends.add');
    // Aquí pondremos más después (aceptar, rechazar, etc.)
});

require __DIR__.'/auth.php';
