<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Si no escribieron nada, redirigir al inicio
        if (!$query) {
            return redirect()->route('dashboard');
        }

        // Buscar usuarios cuyo nombre se parezca a lo que escribieron
        // El simbolo % significa "cualquier cosa antes o despues"
        $users = User::where('name', 'LIKE', "%{$query}%")
                     ->where('id', '!=', auth()->id()) // No mostrarme a mí mismo
                     ->get();

        return view('search.results', compact('users', 'query'));
    }
}
