<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// La ruta oficial de registro
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

// El alias corto '/r' (Facebook lo usaba mucho en correos)
Route::get('/r', function () {
    return redirect()->route('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ZONA DE PRUEBAS VISUALES (Borrar al terminar) ---

// 1. Ver la página de "Verificar Correo"
Route::get('/test/verify', function () {
    return view('auth.verify-email');
});

// 2. Ver la página de "Confirmar Contraseña" (Área segura)
Route::get('/test/confirm', function () {
    return view('auth.confirm-password');
});

// 3. Ver la página de "Cambiar Contraseña" (La que sale tras el clic del email)
Route::get('/test/reset', function () {
    // Simulamos un token y el request para que no de error
    return view('auth.reset-password', ['request' => request()->merge(['token' => 'token-falso'])]);
});

Route::get('/messages', function () {
    return view('messages.index'); // La vista que crearemos ahora
})->name('messages');

Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth'])->name('profile');

Route::get('/pages', function () {
    return view('pages');
})->name('pages.index');

Route::get('/pages/larabook-team', function () {
    return view('page');
})->name('page.show');

Route::get('/groups', function () {
    return view('groups');
})->name('groups.index');

Route::get('/groups/laravel-devs', function () {
    return view('group');
})->name('group.show');

Route::get('/games', function () {
    return view('games');
})->name('games.index');

// 1. La página principal del juego (el marco)
Route::get('/games/smash-friends', function () {
    return view('game_canvas');
})->name('games.play');

// 2. El contenido del iframe (el mensaje del troll de Zuck)
Route::get('/games/api-closed-message', function () {
    // Devolvemos texto plano para que se vea crudo y "roto" dentro del iframe
    return 'No hay juegos porque cerramos nuestro servicio y cerramos las API para que las empresas tengan tus datos y no un juego. 
    
    Atte. Zack. 
    
    Esto nos pasa por la polémica de 2017. 
    Adiós SDKs. 
    
    ¡Deja de acusarnos, Miku! xdxdxdxd';
});

Route::get('/watch', function () {
    return view('watch');
})->name('watch');

Route::get('/marketplace', function () {
    return view('marketplace');
})->name('marketplace');

Route::get('/events', function () {
    return view('events');
})->name('events.index');

Route::get('/saved', function () {
    return view('saved');
})->name('saved.index');

require __DIR__.'/auth.php';
