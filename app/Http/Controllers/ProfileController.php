<?php

namespace App\Http\Controllers;

use App\Models\User; // <--- ¡MUY IMPORTANTE! No olvides importar esto
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // ==========================================
    // PARTE NUEVA: Perfil Público (Timeline)
    // ==========================================

    /**
     * Muestra el perfil público de un usuario específico.
     * Ruta: /user/{username}
     */
    public function show($username)
    {
        // Buscamos al usuario por su username. Si no existe, error 404.
        $user = User::where('username', $username)->firstOrFail();

        // Retornamos la vista visual del perfil (resources/views/profile/index.blade.php)
        // Nota: Asegúrate de que tu vista se llame 'profile.index' o simplemente 'profile' según la carpeta
        if (view()->exists('profile.index')) {
            return view('profile.index', compact('user'));
        }
        
        // Fallback por si guardaste la vista directamente en views/profile.blade.php
        return view('profile', compact('user'));
    }

    /**
     * Redirecciona /profile a tu propia URL pública.
     * Ruta: /profile
     */
    public function index()
    {
        $user = Auth::user();
        // Redirige a la función show() usando tu username
        return Redirect::route('profile.show', $user->username);
    }

    // ==========================================
    // PARTE ORIGINAL BREEZE: Configuración (Settings)
    // ==========================================

    /**
     * Muestra el formulario para editar cuenta (Ahora en /settings).
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza la información de la cuenta.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Elimina la cuenta del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}