<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    // Mostrar lista de grupos (Dashboard de grupos)
    public function index()
    {
        return view('groups.index'); // La vista estática que hicimos antes
    }

    // Formulario de crear
    public function create()
    {
        return view('groups.create');
    }

    // Guardar grupo
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'privacy' => 'required|in:public,closed,secret',
        ]);

        // Crear el grupo
        $group = Group::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(1000, 9999),
            'privacy' => $request->privacy,
            'description' => $request->description,
        ]);

        // IMPORTANTE: Unir al creador como ADMIN inmediatamente
        $group->members()->attach(Auth::id(), ['role' => 'admin', 'status' => 'active']);

        return redirect()->route('groups.show', $group->slug);
    }

    // Ver un grupo específico
    public function show($slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        return view('groups.show', compact('group'));
    }
}