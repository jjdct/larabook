<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Page; // <--- Importamos el modelo Page
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Buscar Usuarios
        $users = User::where('name', 'LIKE', "%{$query}%")
                     ->orWhere('email', 'LIKE', "%{$query}%")
                     ->get();

        // Buscar Páginas (Fan Pages)
        $pages = Page::where('name', 'LIKE', "%{$query}%")
                     ->orWhere('category', 'LIKE', "%{$query}%")
                     ->get();

        // Enviamos ambas colecciones a la vista
        return view('search.results', compact('users', 'pages', 'query'));
    }
}