<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

// 1. RUTA PARA VER EL MURO (Dashboard)
// Ahora usa el DashboardController para cargar Posts + Amigos + Chat
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 2. RUTA PARA PUBLICAR (Usando el Controlador, NO el closure) (Guardar en BD)
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show'); // <--- NUEVA

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Sistema de Amigos
    Route::post('/add-friend/{user}', [FriendshipController::class, 'sendRequest'])->name('friends.add');
    Route::get('/friends/requests', [FriendshipController::class, 'index'])->name('friends.requests');
    Route::post('/friends/accept/{sender}', [FriendshipController::class, 'accept'])->name('friends.accept');
    Route::post('/friends/reject/{sender}', [FriendshipController::class, 'reject'])->name('friends.reject');
    // Buscador
    Route::get('/search', [SearchController::class, 'index'])->name('search');
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

// Sistema de Mensajería
    Route::get('/messages/archived', [MessageController::class, 'archived'])->name('messages.archived'); // <--- NUEVA
    Route::post('/messages/{user}/archive', [MessageController::class, 'archive'])->name('messages.archive'); // <--- NUEVA
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');

// Rutas de Páginas
    Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create')->middleware('auth');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store')->middleware('auth');
    Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show'); 
    
// Rutas de Interacción
    Route::post('/posts/{post}/like', [LikeController::class, 'togglePost'])->name('posts.like');
    Route::post('/posts/{post}/comment', [CommentController::class, 'storePost'])->name('posts.comment');    

Route::middleware(['auth'])->group(function () {
    Route::post('/add-friend/{user}', [FriendshipController::class, 'sendRequest'])->name('friends.add');
    // Aquí pondremos más después (aceptar, rechazar, etc.)
});

require __DIR__.'/auth.php';
