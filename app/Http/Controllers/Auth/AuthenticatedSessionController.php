<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException; // <--- ESTA ERA LA LÍNEA CLAVE QUE FALTABA

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            // Intenta loguear
            $request->authenticate();
        
        } catch (ValidationException $e) {
            // SI FALLA (Contraseña mal):
            // Redirige SIEMPRE a la página de login dedicada (/login)
            // llevando los errores y el email que escribió
            return redirect()->route('login')
                ->withInput($request->only('email'))
                ->withErrors($e->errors());
        }

        // Si pasa, regenera sesión y entra al Dashboard
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}