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
        padding: 8px;
        font-size: 14px;
        color: #4b4f56;
        cursor: pointer;
        border-left: 2px solid transparent;
        display: block;
        text-decoration: none;
    }
    .filter-item:hover { background-color: #f5f6f7; }
    
    .filter-item.active {
        font-weight: bold;
        color: #1c1e21;
        background-color: #f5f6f7;
        border-left-color: #3b5998;
    }
</style>
@endpush

@section('content')
<div class="flex gap-4">
    
    <div class="w-[200px] hidden md:block flex-shrink-0">
        <div class="font-bold text-[#4b4f56] text-xs uppercase mb-2 px-1">Filtros</div>
        <div class="bg-white border border-[#dddfe2] rounded-sm">
            
            <a href="{{ route('search', ['q' => $query, 'type' => 'all']) }}" 
               class="filter-item {{ $type == 'all' ? 'active' : '' }}">
               Todo
            </a>
            
            <a href="{{ route('search', ['q' => $query, 'type' => 'users']) }}" 
               class="filter-item {{ $type == 'users' ? 'active' : '' }}">
               Personas
            </a>
            
            <a href="{{ route('search', ['q' => $query, 'type' => 'pages']) }}" 
               class="filter-item {{ $type == 'pages' ? 'active' : '' }}">
               Páginas
            </a>
            
            <a href="{{ route('search', ['q' => $query, 'type' => 'groups']) }}" 
               class="filter-item {{ $type == 'groups' ? 'active' : '' }}">
               Grupos
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
            </div>
        
        @else

            @if($users->isNotEmpty())
            <div class="card-search">
                <div class="search-header">Personas</div>
                @foreach($users as $user)
                    <div class="result-item">
                        <a href="{{ url('/profile') }}" class="mr-3">
                            <img src="{{ $user->avatar }}" class="result-avatar rounded-full border border-black/10">
                        </a>
                        <div class="flex-grow">
                            <div class="flex items-center gap-1">
                                <a href="{{ url('/profile') }}" class="font-bold text-[#365899] text-[16px] hover:underline">
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