<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Unir fecha (Tu lógica existente)
        if ($request->has(['day', 'month', 'year'])) {
            $fullDate = sprintf('%04d-%02d-%02d', $request->year, $request->month, $request->day);
            $request->merge(['birthday' => $fullDate]);
        }

        // 2. Validación (Actualizada para nullable)
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'birthday' => ['required', 'date', 'before:today'],
                'gender' => ['required', 'string'], // Acepta 'male', 'female', 'custom'
        
            // Estos son opcionales (nullable)
                'pronoun' => ['nullable', 'string', 'in:he,she,they'],
                'custom_gender_string' => ['nullable', 'string', 'max:50'], 
        ]);

        // 3. Username
        $baseSlug = Str::slug($request->first_name . '.' . $request->last_name);
        $username = $baseSlug . '.' . rand(100, 9999);
        while (User::where('username', $username)->exists()) {
            $username = $baseSlug . '.' . rand(100, 9999);
        }

        // 4. Crear Usuario (Mapeando los campos extra)
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
        
            'gender' => $request->gender, // 'male', 'female' o 'custom'
        
            // Guardamos solo si eligió custom
            'pronoun' => ($request->gender === 'custom') ? $request->pronoun : null,
            // Ojo: En el form se llama 'custom_gender_string', en la DB 'custom_gender'
            'custom_gender' => ($request->gender === 'custom') ? $request->custom_gender_string : null,
        
            // Dejamos bio, profile_photo y cover_photo como null por defecto
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
