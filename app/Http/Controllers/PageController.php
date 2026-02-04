<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Mostrar el formulario de creación
    public function create()
    {
        return view('pages.create');
    }

    // Guardar la página en la BD
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|max:100',
            'description' => 'nullable|max:500',
        ]);

        // Generar un username único (slug + números aleatorios)
        $baseSlug = Str::slug($request->name);
        $username = $baseSlug . '-' . rand(1000, 9999);

        // Crear la página vinculada al usuario actual
        $page = Page::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'username' => $username,
            'category' => $request->category,
            'description' => $request->description,
            // Las fotos se quedan null por ahora (saldrá la bandera gris)
        ]);

        // Por ahora redirigimos al dashboard con un mensaje
        // (Más adelante redirigiremos a la vista dinámica de la página)
        return redirect()->route('dashboard')->with('status', '¡Página creada exitosamente!');
    }

    public function show($username)
    {
        // Busca la página. Si no existe, lanza error 404 automáticamente.
        $page = Page::where('username', $username)->firstOrFail();

        return view('pages.show', compact('page'));
    }
}