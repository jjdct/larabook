<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\Auth\RegisteredUserController; // Asegúrate de importar esto para el registro

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS / GENERALES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// El alias corto '/r'
Route::get('/r', function () {
    return redirect()->route('register');
});

// ZONA DE PRUEBAS VISUALES (Opcional: Borrar cuando quieras)
Route::get('/test/verify', fn() => view('auth.verify-email'));
Route::get('/test/confirm', fn() => view('auth.confirm-password'));
Route::get('/test/reset', fn() => view('auth.reset-password', ['request' => request()->merge(['token' => 'fake'])]));


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD / FEED
    // Apuntamos a la vista 'feed' que creamos ayer (el muro real)
    Route::get('/dashboard', function () {
        return view('feed'); 
    })->name('dashboard');


    // 2. CONFIGURACIÓN DE CUENTA (Antes era /profile en Breeze)
    // Lo movemos a /settings para liberar /profile
    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // 3. PERFIL DE USUARIO (TIMELINE)
    // Redirección simple: /profile -> /user/tu-usuario
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    // Perfil público: /user/{username}
    Route::get('/user/{username}', [ProfileController::class, 'show'])->name('profile.show');


    // 4. GRUPOS (Lógica Dinámica Completa)
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{slug}', [GroupController::class, 'show'])->name('groups.show');


    // 5. PÁGINAS (Lógica Dinámica)
    // Nota: Aún no tenemos un index de páginas (dashboard de páginas), 
    // así que dejamos la vista estática 'pages' solo en la ruta base si quieres,
    // o usamos un controlador futuro. Por ahora dejamos la vista simple.
    Route::get('/pages', function () { return view('pages'); })->name('pages.index');
    
    Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    // Ruta dinámica para ver páginas
    Route::get('/pages/{username}', [PageController::class, 'show'])->name('pages.show');


    // 6. BÚSQUEDA
    Route::get('/search', [SearchController::class, 'index'])->name('search');


    // 7. SECCIONES AÚN ESTÁTICAS (Placeholders)
    // Estas se quedarán así hasta que hagamos sus controladores
    Route::get('/messages', fn() => view('messages.index'))->name('messages');
    Route::get('/games', fn() => view('games'))->name('games.index');
    Route::get('/watch', fn() => view('watch'))->name('watch');
    Route::get('/marketplace', fn() => view('marketplace'))->name('marketplace');
    Route::get('/events', fn() => view('events'))->name('events.index');
    Route::get('/saved', fn() => view('saved'))->name('saved.index');
    Route::get('/memories', fn() => view('memories'))->name('memories');
    
    // El juego del troll (Iframe)
    Route::get('/games/smash-friends', fn() => view('game_canvas'))->name('games.play');
    Route::get('/games/api-closed-message', function () {
        return 'No hay juegos porque cerramos nuestro servicio... Atte. Zack.';
    });

    // RUTAS DE AMISTAD
    // Usamos {user} para que Laravel inyecte el modelo automáticamente usando el ID
    Route::post('/friend/add/{user}', [FriendshipController::class, 'add'])->name('friend.add');
    Route::post('/friend/accept/{user}', [FriendshipController::class, 'accept'])->name('friend.accept');
    Route::post('/friend/reject/{user}', [FriendshipController::class, 'reject'])->name('friend.reject');
    // Página dedicada de amigos
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');

});

// AUTH (Login/Register)
require __DIR__.'/auth.php';