<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PostController; // <--- Importante
use App\Http\Controllers\CommentController; // <--- Importante
use App\Http\Controllers\ReactionController; // <--- Importante

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/r', function () {
    return redirect()->route('register');
});


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD / FEED
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    // 2. PERFIL Y AJUSTES
    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Fotos de Perfil y Portada
    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update_photo');

    // Visualización de Perfil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/user/{username}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/user/{username}/about', [ProfileController::class, 'about'])->name('profile.about');
    Route::get('/user/{username}/friends', [ProfileController::class, 'friends'])->name('profile.friends');
    Route::get('/user/{username}/photos', [ProfileController::class, 'photos'])->name('profile.photos');
    Route::get('/user/{username}/videos', [ProfileController::class, 'videos'])->name('profile.videos');
    Route::get('/user/{username}/sports', [ProfileController::class, 'sports'])->name('profile.sports');
    Route::get('/user/{username}/music', [ProfileController::class, 'music'])->name('profile.music');
    Route::get('/user/{username}/movies', [ProfileController::class, 'movies'])->name('profile.movies');
    Route::get('/user/{username}/books', [ProfileController::class, 'books'])->name('profile.books');
    Route::get('/user/{username}/likes', [ProfileController::class, 'likes'])->name('profile.likes');
    Route::get('/profile/log', [ProfileController::class, 'log'])->name('profile.log');

    // ESTA ES LA RUTA QUE TE FALTABA 👇
    // Publicar en el muro de un usuario (Mio o de amigo)
    Route::post('/profile/{user}/post', [ProfileController::class, 'storePost'])->name('profile.post.store');


    // 3. POSTS (CRUD y Acciones)
    Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');     // Ver Post individual
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy'); // Borrar Post
    Route::post('/post/{post}/save', [PostController::class, 'toggleSave'])->name('post.save'); // Guardar Post

    // 4. INTERACCIONES (Comentarios y Reacciones)
    Route::post('/post/{post}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/reaction', [ReactionController::class, 'toggle'])->name('reaction.toggle');
    Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
    Route::post('/post/{post}/share', [PostController::class, 'share'])->name('post.share');
    // Ruta para publicar en el Feed principal (Tu muro)
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // 5. AMIGOS
    Route::post('/friend/add/{user}', [FriendshipController::class, 'add'])->name('friend.add');
    Route::post('/friend/accept/{user}', [FriendshipController::class, 'accept'])->name('friend.accept');
    Route::post('/friend/reject/{user}', [FriendshipController::class, 'reject'])->name('friend.reject');
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');


    // 6. GRUPOS
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{slug}', [GroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{slug}/post', [GroupController::class, 'storePost'])->name('groups.post.store');


    // 7. PÁGINAS
    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{username}', [PageController::class, 'show'])->name('pages.show');
    Route::post('/pages/{username}/post', [PageController::class, 'storePost'])->name('pages.post.store');
    // En routes/web.php
    Route::get('/pages/{username}', [PageController::class, 'show'])->name('pages.show');
    Route::get('/pages/{username}/about', [PageController::class, 'about'])->name('pages.about');
    Route::get('/pages/{username}/photos', [PageController::class, 'photos'])->name('pages.photos');


    // 8. BÚSQUEDA
    Route::get('/search', [SearchController::class, 'index'])->name('search');


    // 9. PLACEHOLDERS (Secciones estáticas)
    Route::get('/messages', fn() => view('messages.index'))->name('messages');
    Route::get('/games', fn() => view('games'))->name('games.index');
    Route::get('/watch', fn() => view('watch'))->name('watch');
    Route::get('/marketplace', fn() => view('marketplace'))->name('marketplace');
    Route::get('/events', fn() => view('events'))->name('events.index');
    Route::get('/saved', fn() => view('saved'))->name('saved.index');
    Route::get('/memories', fn() => view('memories'))->name('memories');

    Route::get('/notifications/{id}', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead(); // Laravel Magic
    return redirect($notification->data['link']); // Nos lleva al post
    })->name('notifications.show');

    Route::post('/notifications/mark-all', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
    })->name('notifications.readAll');
    
    // Juegos
    Route::get('/games/smash-friends', fn() => view('game_canvas'))->name('games.play');

    // Rutas de prueba (Opcional)
    Route::get('/test-500', function () { abort(500); });
});

/*
|--------------------------------------------------------------------------
| AUTH & FALLBACK
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});