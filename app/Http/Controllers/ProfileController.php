<?php

namespace App\Http\Controllers;

use App\Models\User; // <--- ¡MUY IMPORTANTE! No olvides importar esto
use App\Models\Post;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // Importante para subir archivos

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

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'type' => 'required|in:avatar,cover',
            'image' => 'required|image|max:5120', // Max 5MB
        ]);

        $user = auth()->user();
        $type = $request->type;
        
        // 1. Guardar la imagen en Storage
        // Se guardará en storage/app/public/profiles
        $path = $request->file('image')->store('profiles', 'public');
        $url = Storage::url($path);

        // 2. Actualizar el campo en la tabla users
        $user->update([$type => $url]);

        // 3. Crear el Post Automático (Como en 2018)
        // Ejemplo: "Miku actualizó su foto de portada."
        $actionText = ($type === 'avatar') ? 'actualizó su foto de perfil.' : 'actualizó su foto de portada.';
        
        Post::create([
            'user_id' => $user->id,
            'author_type' => \App\Models\User::class,
            'author_id' => $user->id,
            'wall_type' => \App\Models\User::class,
            'wall_id' => $user->id, // Siempre en mi propio muro
            'content' => $actionText, 
            'attachments' => [$path], // Guardamos la foto como attachment del post
            'privacy' => 'public',
            'status' => 'published'
        ]);

        return back()->with('status', 'Foto actualizada correctamente.');
    }

    /**
     * Crear un post en el muro de un perfil (propio o de amigo).
     */
    public function storePost(Request $request, \App\Models\User $user)
    {
        // Validar: Solo texto o con imagen (lógica básica por ahora)
        $request->validate(['content' => 'required_without:image|string']);

        $attachments = null;
        // Aquí iría la lógica de subir imagen al post si quisieras
        
        Post::create([
            'user_id' => auth()->id(), // El que escribe (YO)
            'author_type' => \App\Models\User::class,
            'author_id' => auth()->id(),
            
            // EL DESTINO: El usuario dueño del perfil que visito ($user)
            'wall_type' => \App\Models\User::class,
            'wall_id' => $user->id,
            
            'content' => $request->content,
            'attachments' => $attachments,
            'privacy' => 'public', // Ojo: Aquí podrías heredar la privacidad del muro
        ]);

        return back();
    }

    public function about($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.about', compact('user'));
    }

    public function friends($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        // Carga ansiosa para evitar N+1 queries
        $user->load('friends'); 
        return view('profile.friends', compact('user'));
    }

    public function photos($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.photos', compact('user'));
    }

    public function videos($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.videos', compact('user'));
    }

    public function sports($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.sports', compact('user'));
    }

    public function music($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.music', compact('user'));
    }

    public function movies($username) {
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.movies', compact('user'));
    }
    
    public function books($username) {
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.books', compact('user'));
    }
    
    public function likes($username) {
        $user = User::where('username', $username)->firstOrFail();
        return view('profile.likes', compact('user'));
    }

    public function log()
    {
        // Solo yo puedo ver mi log
        $user = Auth::user();
        
        // Cargamos relaciones necesarias
        $user->load(['posts', 'comments']); 
        
        return view('profile.log', compact('user'));
    }
}