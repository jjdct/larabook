@extends('layouts.app')

@section('title', 'Resultados de búsqueda | Larabook')

@push('styles')
<style>
    /* Estilos de cabecera de sección */
    .search-header {
        background: #f5f6f7;
        padding: 10px 12px;
        border-bottom: 1px solid #dddfe2;
        font-weight: bold;
        color: #4b4f56;
        font-size: 14px;
        border-radius: 3px 3px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    /* Fila de resultado */
    .result-item {
        display: flex;
        padding: 12px;
        border-bottom: 1px solid #e9ebee;
        align-items: center;
        background: white;
    }
    .result-item:last-child { border-bottom: none; }
    
    /* Avatar base */
    .result-avatar { 
        width: 72px; 
        height: 72px; 
        object-fit: cover; 
    }
    
    /* Botones de acción */
    .btn-action-search {
        background: #f5f6f7;
        border: 1px solid #ccd0d5;
        color: #4b4f56;
        font-weight: bold;
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 2px;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-action-search:hover { background: #e9ebee; }
    
    /* Contenedor tipo tarjeta */
    .card-search {
        background: white; 
        border: 1px solid #dddfe2; 
        border-radius: 3px; 
        margin-bottom: 12px;
    }

    /* Estilos del Sidebar Activo */
    .filter-item {
        padding: 8px 12px;
        font-size: 14px;
        color: #4b4f56;
        cursor: pointer;
        border-left: 2px solid transparent;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }
    .filter-item:hover { background-color: #f5f6f7; }
    
    .filter-item.active {
        font-weight: bold;
        color: #1c1e21;
        background-color: #f5f6f7;
        border-left-color: #3b5998;
    }
    
    /* Utilidad para iconos */
    .filter-icon {
        width: 20px; 
        height: 20px; 
        fill: #606770; /* Gris icono normal */
    }
    .filter-item.active .filter-icon {
        fill: #3b5998; /* Azul activo */
    }
</style>
@endpush

@section('content')
<div class="flex gap-4 pt-4">
    
    <div class="w-[200px] hidden md:block flex-shrink-0">
        <div class="font-bold text-[#4b4f56] text-xs uppercase mb-2 px-1">Filtros</div>
        <div class="bg-white border border-[#dddfe2] rounded-sm py-2">
            
            <a href="{{ route('search', ['q' => $query, 'type' => 'all']) }}" 
               class="filter-item {{ $type == 'all' ? 'active' : '' }}">
               <svg class="filter-icon" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
               Todo
            </a>
            
            <a href="{{ route('search', ['q' => $query, 'type' => 'users']) }}" 
               class="filter-item {{ $type == 'users' ? 'active' : '' }}">
               <svg class="filter-icon" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
               Personas
            </a>
            
            <a href="{{ route('search', ['q' => $query, 'type' => 'pages']) }}" 
               class="filter-item {{ $type == 'pages' ? 'active' : '' }}">
               <svg class="filter-icon" viewBox="0 0 24 24"><path d="M14.4 6L14 4H5v17h2v-7h5.6l.4 2h7V6z"/></svg>
               Páginas
            </a>
            
            <a href="{{ route('search', ['q' => $query, 'type' => 'groups']) }}" 
               class="filter-item {{ $type == 'groups' ? 'active' : '' }}">
               <svg class="filter-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
               Grupos
            </a>

            <a href="{{ route('search', ['q' => $query, 'type' => 'games']) }}" 
               class="filter-item {{ $type == 'games' ? 'active' : '' }}">
               <svg class="filter-icon" viewBox="0 0 24 24"><path d="M21 6H3c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-10 7H8v3H6v-3H3v-2h3V8h2v3h3v2zm4.5 2c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm4-3c-.83 0-1.5-.67-1.5-1.5S18.67 9 19.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
               Juegos
            </a>

            <a href="{{ route('search', ['q' => $query, 'type' => 'events']) }}" 
               class="filter-item {{ $type == 'events' ? 'active' : '' }}">
               <svg class="filter-icon" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.99 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
               Eventos
            </a>

        </div>
    </div>

    <div class="w-[550px]">
        
        @if(!$query)
            <div class="card-search p-8 text-center text-gray-500">
                Escribe un nombre en la barra de búsqueda para empezar.
            </div>
        
        @elseif($users->isEmpty() && $pages->isEmpty() && $groups->isEmpty())
             <div class="card-search p-8 text-center text-gray-500">
                No encontramos resultados para "<strong>{{ $query }}</strong>".
                <div class="text-xs mt-2">Intenta verificar la ortografía o usar palabras clave diferentes.</div>
                
                @if($type == 'games')
                    <div class="mt-4 text-xs font-bold text-gray-400">🔍 Buscando en App Center... (Sin resultados)</div>
                @endif
                @if($type == 'events')
                    <div class="mt-4 text-xs font-bold text-gray-400">📅 Buscando en Calendario... (Sin resultados)</div>
                @endif
            </div>
        
        @else

            @if($users->isNotEmpty())
            <div class="card-search">
                <div class="search-header">Personas</div>
                @foreach($users as $user)
                    <div class="result-item">
                        <a href="{{ route('profile.show', $user->username) }}" class="mr-3">
                            <img src="{{ $user->avatar }}" class="result-avatar rounded-full border border-black/10">
                        </a>
                        <div class="flex-grow">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('profile.show', $user->username) }}" class="font-bold text-[#365899] text-[16px] hover:underline">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </a>
                                @if($user->is_verified)
                                    <span class="text-[#1877f2] text-[12px] bg-gray-100 rounded-full w-4 h-4 flex items-center justify-center" title="Verificado">✓</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $user->bio ? Str::limit($user->bio, 60) : '@' . $user->username }}
                            </div>
                        </div>
                        <button class="btn-action-search">
                            <span class="text-lg leading-none font-bold">+</span> 1 Añadir
                        </button>
                    </div>
                @endforeach
            </div>
            @endif

            @if($pages->isNotEmpty())
            <div class="card-search">
                <div class="search-header">Páginas</div>
                @foreach($pages as $page)
                    <div class="result-item">
                        <a href="{{ route('pages.show', $page->username) }}" class="mr-3">
                            <img src="{{ $page->avatar }}" class="result-avatar rounded-[2px] p-1 bg-gray-50 border border-black/10">
                        </a>
                        <div class="flex-grow">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('pages.show', $page->username) }}" class="font-bold text-[#365899] text-[16px] hover:underline">
                                    {{ $page->name }}
                                </a>
                                @if($page->is_verified)
                                    <span class="text-[#1877f2] text-[12px] bg-gray-100 rounded-full w-4 h-4 flex items-center justify-center" title="Verificado">✓</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $page->category ?? 'Página' }} · {{ $page->location ?? 'Internet' }}
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5">
                                {{ rand(100, 5000) }} personas les gusta esto
                            </div>
                        </div>
                        <button class="btn-action-search">
                            👍 Me gusta
                        </button>
                    </div>
                @endforeach
            </div>
            @endif

            @if($groups->isNotEmpty())
            <div class="card-search">
                <div class="search-header">Grupos</div>
                @foreach($groups as $group)
                    <div class="result-item">
                        <a href="{{ route('groups.show', $group->slug) }}" class="mr-3">
                            <img src="{{ $group->avatar }}" class="result-avatar rounded-lg border border-black/10 object-cover">
                        </a>
                        <div class="flex-grow">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('groups.show', $group->slug) }}" class="font-bold text-[#365899] text-[16px] hover:underline">
                                    {{ $group->name }}
                                </a>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                @if($group->privacy == 'public') 🌎 Grupo público
                                @elseif($group->privacy == 'closed') 🔒 Grupo cerrado
                                @else 👁️ Grupo secreto
                                @endif
                                · {{ $group->members->count() }} miembros
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5">
                                {{ Str::limit($group->description, 60) }}
                            </div>
                        </div>
                        <button class="btn-action-search">
                            + Unirte
                        </button>
                    </div>
                @endforeach
            </div>
            @endif

        @endif

    </div>
</div>
@endsection