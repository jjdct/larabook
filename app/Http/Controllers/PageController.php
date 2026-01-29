<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Mostrar formulario de crear página
    public function create()
    {
        return view('pages.create');
    }

    // Guardar la página en la DB
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required',
            'about' => 'nullable|max:500',
        ]);

        // Crear el slug (URL amigable)
        $slug = Str::slug($request->name);
        
        // Asegurar que el slug sea único (si existe "tacos", usar "tacos-1")
        $count = Page::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $page = Page::create([
            'user_id' => Auth::id(), // El creador es el dueño
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
            'about' => $request->about,
        ]);

        // Auto-Like: El creador es el primer fan
        $page->fans()->attach(Auth::id());

        return redirect()->route('pages.show', $page->slug);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        
        // ¿El usuario actual es fan?
        $isFan = Auth::check() ? $page->fans->contains(Auth::id()) : false;

        // OBTENER POSTS DE LA PÁGINA
        // Por ahora enviamos una colección vacía para que no falle la vista.
        // (Más adelante haremos que las páginas puedan tener sus propios posts)
        $posts = collect(); 

        return view('pages.show', compact('page', 'isFan', 'posts'));
    }
}
