@extends('layouts.app')

@section('title', 'Crear grupo nuevo | Larabook')

@section('content')
<div class="flex justify-center mt-6">
    <div class="card w-[600px] p-0 overflow-hidden">
        <div class="p-4 border-b border-[#dddfe2] bg-[#f5f6f7]">
            <h1 class="text-lg font-bold text-[#1c1e21]">Crear grupo nuevo</h1>
        </div>
        
        <form action="{{ route('groups.store') }}" method="POST" class="p-4">
            @csrf
            
            <div class="mb-4">
                <label class="block text-xs font-bold text-[#90949c] mb-1 uppercase">Nombre del grupo</label>
                <input type="text" name="name" class="w-full border border-[#ccd0d5] p-2 rounded-sm text-sm focus:border-[#1877f2] outline-none" placeholder="Asigna un nombre a tu grupo" required>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-[#90949c] mb-1 uppercase">Privacidad</label>
                <div class="relative">
                    <select name="privacy" class="w-full border border-[#ccd0d5] p-2 rounded-sm text-sm appearance-none bg-white">
                        <option value="public">🌎 Grupo público (Cualquiera puede ver el grupo y sus publicaciones)</option>
                        <option value="closed">🔒 Grupo cerrado (Cualquiera puede buscar el grupo, solo miembros ven posts)</option>
                        <option value="secret">👁️ Grupo secreto (Solo los miembros pueden encontrar el grupo)</option>
                    </select>
                    <div class="absolute right-3 top-2.5 text-gray-500 pointer-events-none">▼</div>
                </div>
            </div>

            <div class="mb-4">
                 <label class="block text-xs font-bold text-[#90949c] mb-1 uppercase">Descripción (Opcional)</label>
                 <textarea name="description" rows="3" class="w-full border border-[#ccd0d5] p-2 rounded-sm text-sm focus:border-[#1877f2] outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-[#dddfe2]">
                <a href="{{ route('groups.index') }}" class="px-4 py-1.5 font-bold text-[#4b4f56] hover:bg-[#f5f6f7] rounded border border-transparent text-sm">Cancelar</a>
                <button type="submit" class="px-6 py-1.5 bg-[#1877f2] hover:bg-[#166fe5] text-white font-bold rounded shadow-sm text-sm border border-[#1877f2]">
                    Crear
                </button>
            </div>
        </form>
    </div>
</div>
@endsection