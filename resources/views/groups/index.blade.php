@extends('layouts.app')

@section('title', 'Grupos | Larabook')

@push('styles')
<style>
    /* Layout */
    .groups-container { display: flex; height: calc(100vh - 42px); background-color: #f0f2f5; }
    
    /* Sidebar */
    .groups-sidebar { width: 360px; background: white; border-right: 1px solid #d3d6db; padding: 16px; overflow-y: auto; flex-shrink: 0; }
    
    /* Contenido */
    .groups-content { flex-grow: 1; padding: 24px 32px; overflow-y: auto; }

    /* Nav Items */
    .groups-nav-item { display: flex; align-items: center; padding: 8px 10px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 15px; color: #050505; margin-bottom: 2px; text-decoration: none; }
    .groups-nav-item:hover { background-color: #f0f2f5; }
    .groups-nav-item.active { background-color: #e7f3ff; color: #1877f2; }

    .groups-icon-bg { width: 36px; height: 36px; background: #e4e6eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 18px; }
    .active .groups-icon-bg { background: #1877f2; color: white; }

    /* Group Cards */
    .group-card { background: white; border-radius: 8px; overflow: hidden; border: 1px solid #dddfe2; display: flex; flex-direction: column; justify-content: space-between; height: 100%; }
    .group-cover-preview { height: 100px; width: 100%; object-fit: cover; }
    .group-info { padding: 12px; flex-grow: 1; }
    .group-name { font-weight: bold; font-size: 16px; color: #050505; margin-bottom: 4px; line-height: 1.2; }
    .group-members { font-size: 12px; color: #65676b; }
    .btn-join-group { width: 100%; background: #e7f3ff; color: #1877f2; font-weight: bold; padding: 8px 0; border-radius: 6px; font-size: 14px; margin-top: 10px; border: none; transition: background 0.2s; cursor: pointer; }
    .btn-join-group:hover { background: #dbe7f2; }

    /* Feed Activity */
    .group-feed-item { background: white; padding: 15px; border-radius: 8px; border: 1px solid #dddfe2; margin-bottom: 12px; }
</style>
@endpush

@section('content')
<div class="-mt-4 groups-container">

    <div class="groups-sidebar hidden md:block">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-[#050505]">Grupos</h1>
            <button class="bg-[#e4e6eb] w-9 h-9 rounded-full flex items-center justify-center hover:bg-[#d8dadf]">⚙️</button>
        </div>

        <div class="relative mb-4">
            <span class="absolute left-3 top-2.5 text-gray-500">🔍</span>
            <input type="text" placeholder="Buscar grupos" class="w-full bg-[#f0f2f5] border-none rounded-full py-2 pl-10 pr-4 text-[15px] outline-none focus:ring-1 focus:ring-gray-300">
        </div>
        
        <div class="groups-nav-item active">
            <div class="groups-icon-bg">📰</div>
            Feed de tus grupos
        </div>
        <div class="groups-nav-item">
            <div class="groups-icon-bg">🧭</div>
            Descubrir
        </div>
        <a href="{{ route('groups.create') }}" class="groups-nav-item">
            <div class="groups-icon-bg">➕</div>
            Crear nuevo grupo
        </a>

        <div class="border-t border-[#d3d6db] my-3 mx-2"></div>
        
        <div class="font-bold text-[16px] mb-2 px-2 text-[#65676b]">Tus grupos</div>
        
        {{-- BUCLE DINÁMICO DE MIS GRUPOS --}}
        @forelse($myGroups as $group)
            <a href="{{ route('groups.show', $group->slug) }}" class="groups-nav-item hover:no-underline">
                <img src="{{ $group->avatar }}" class="w-9 h-9 rounded-md mr-3 object-cover border border-gray-200">
                <div class="flex flex-col">
                    <span class="text-[#050505] font-semibold text-sm line-clamp-1">{{ $group->name }}</span>
                    {{-- Badge visual de actividad aleatoria (puedes quitarlo si prefieres) --}}
                    @if(rand(0,1)) 
                        <span class="text-[11px] text-[#1877f2] font-bold">● Actividad reciente</span>
                    @endif
                </div>
            </a>
        @empty
            <div class="px-4 py-2 text-sm text-gray-500">
                No te has unido a ningún grupo aún.
            </div>
        @endforelse

    </div>

    <div class="groups-content">
        
        <div class="mb-6">
            <h2 class="text-lg font-bold text-[#050505] mb-3">Actividad reciente</h2>
            
            @forelse($feedPosts as $post)
                <div class="group-feed-item">
                    {{-- Cabecera: Nombre del Grupo --}}
                    <div class="flex items-center gap-2 mb-2">
                        <a href="{{ route('groups.show', $post->wall->slug) }}" class="flex items-center gap-2 hover:underline">
                            <img src="{{ $post->wall->avatar }}" class="w-6 h-6 rounded-md object-cover">
                            <span class="font-bold text-sm text-[#050505]">{{ $post->wall->name }}</span>
                        </a>
                        <span class="text-xs text-gray-500">• {{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    {{-- Contenido: Autor y Texto --}}
                    <div class="flex gap-3">
                        <img src="{{ $post->author->avatar }}" class="w-10 h-10 rounded-full border border-gray-200">
                        <div>
                            <div class="font-bold text-sm text-[#050505]">{{ $post->author->name }}</div>
                            <p class="text-sm text-[#050505] mt-1">{{ Str::limit($post->content, 200) }}</p>
                            
                            @if(!empty($post->attachments))
                                <div class="mt-2 text-xs text-blue-600 font-semibold">[Contiene adjuntos]</div>
                            @endif

                            <div class="flex gap-4 mt-3 text-sm text-[#65676b] font-bold">
                                <span class="cursor-pointer hover:underline">Me gusta</span>
                                <span class="cursor-pointer hover:underline">Comentar</span>
                                <a href="{{ route('groups.show', $post->wall->slug) }}" class="cursor-pointer hover:underline">Ver</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded-lg text-center text-gray-500 border border-dashed border-gray-300">
                    <div class="text-4xl mb-2">📭</div>
                    <div class="font-bold">No hay actividad reciente</div>
                    <div class="text-sm mt-1">Únete a grupos para ver aquí lo que publican.</div>
                </div>
            @endforelse
        </div>

        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-bold text-[#050505]">Sugerencias para ti</h2>
            <a href="#" class="text-[#1877f2] text-sm hover:underline">Ver todo</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
            
            @forelse($suggestedGroups as $group)
                <div class="group-card">
                    <a href="{{ route('groups.show', $group->slug) }}" class="block">
                        <img src="{{ $group->cover }}" class="group-cover-preview">
                        <div class="group-info">
                            <div class="group-name truncate" title="{{ $group->name }}">{{ $group->name }}</div>
                            <div class="group-members">{{ $group->members_count }} miembros · Grupo {{ $group->privacy }}</div>
                        </div>
                    </a>
                    <div class="p-3 pt-0">
                        <button class="btn-join-group">Unirte al grupo</button>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center text-gray-500 bg-white rounded border border-gray-200">
                    <div class="text-2xl mb-2">🔍</div>
                    No hay nuevos grupos para sugerir.
                </div>
            @endforelse

        </div>
    </div>

</div>
@endsection