<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Page; // <--- Importante: Importar el modelo Page
use App\Models\Group; // <--- Importar esto
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'all'); // Por defecto 'all'

        // Inicializamos colecciones vacías
        $users = collect();
        $pages = collect();
        $groups = collect();

        if ($query) {
            // 1. BUSCAR USUARIOS (Si type es 'all' o 'users')
            if ($type === 'all' || $type === 'users') {
                $users = User::where('first_name', 'LIKE', "%{$query}%")
                             ->orWhere('last_name', 'LIKE', "%{$query}%")
                             ->orWhere('username', 'LIKE', "%{$query}%")
                             ->get();
            }

            // 2. BUSCAR PÁGINAS (Si type es 'all' o 'pages')
            if ($type === 'all' || $type === 'pages') {
                $pages = Page::where('name', 'LIKE', "%{$query}%")
                             ->orWhere('username', 'LIKE', "%{$query}%")
                             ->orWhere('category', 'LIKE', "%{$query}%")
                             ->get();
            }

            // 3. BUSCAR GRUPOS (Si type es 'all' o 'groups')
            if ($type === 'all' || $type === 'groups') {
                $groups = Group::where('name', 'LIKE', "%{$query}%")
                               ->orWhere('description', 'LIKE', "%{$query}%")
                               ->get();
            }
        }

        return view('search.index', compact('users', 'pages', 'groups', 'query', 'type'));
    }
}