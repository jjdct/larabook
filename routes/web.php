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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

require __DIR__.'/auth.php';
