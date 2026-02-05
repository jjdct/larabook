@extends('layouts.app')

@section('title', 'Páginas | Larabook')

@push('styles')
<style>
    /* Layout */
    .pages-container { display: flex; min-height: calc(100vh - 42px); background-color: #f0f2f5; }
    
    /* Sidebar */
    .pages-sidebar { width: 360px; background: white; border-right: 1px solid #d3d6db; padding: 16px; position: sticky; top: 42px; height: calc(100vh - 42px); overflow-y: auto; flex-shrink: 0; }
    
    /* Contenido */
    .pages-content { flex-grow: 1; padding: 24px 32px; }

    /* Nav Items */
    .pages-nav-item { display: flex; align-items: center; padding: 8px 10px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 15px; color: #050505; margin-bottom: 2px; text-decoration: none; }
    .pages-nav-item:hover { background-color: #f0f2f5; }
    /* Clase active dinámica */
    .pages-nav-item.active { background-color: #e7f3ff; color: #1877f2; }

    .pages-icon-bg { width: 36px; height: 36px; background: #e4e6eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; color: #050505; }
    .active .pages-icon-bg { background: #1877f2; color: white; }

    /* Cards */
    .page-card { background: white; border-radius: 8px; overflow: hidden; border: 1px solid #dddfe2; display: flex; flex-direction: column; align-items: center; padding-bottom: 12px; transition: box-shadow 0.2s; height: 100%; }
    .page-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    
    .page-cover-preview { height: 100px; width: 100%; background: #333; object-fit: cover; }
    .page-avatar-preview { width: 70px; height: 70px; border-radius: 50%; border: 3px solid white; margin-top: -35px; background: white; object-fit: cover; }
    
    .page-name { font-weight: bold; font-size: 16px; color: #050505; margin-top: 8px; text-align: center; padding: 0 10px; line-height: 1.2; }
    .page-cat { font-size: 12px; color: #65676b; margin-bottom: 12px; margin-top: 4px; }

    .btn-like-page { background: #e4e6eb; color: #050505; font-weight: bold; padding: 8px 0; border-radius: 6px; font-size: 14px; width: 85%; text-align: center; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: auto; }
    .btn-like-page:hover { background: #d8dadf; }
</style>
@endpush

@section('content')
<div class="pages-container">

    <div class="pages-sidebar hidden md:block">
        <h1 class="text-2xl font-bold text-[#050505] mb-4">Páginas</h1>

        <a href="{{ route('pages.create') }}" class="w-full bg-[#e7f3ff] hover:bg-[#dbe7f2] text-[#1877f2] font-bold py-2 rounded-md mb-4 flex items-center justify-center gap-2">
            <span class="text-xl">+</span> Crear nueva página
        </a>
        
        {{-- MENÚ FILTROS --}}
        
        {{-- 1. PÁGINAS QUE TE GUSTAN --}}
        <a href="{{ route('pages.index', ['view' => 'liked']) }}" class="pages-nav-item {{ $view === 'liked' ? 'active' : '' }}">
            <div class="pages-icon-bg">
                <svg viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M14.4 6L14 4H5v17h2v-7h5.6l.4 2h7V6z"/></svg>
            </div>
            Páginas que te gustan
        </a>
        
        {{-- 2. INVITACIONES --}}
        <div class="pages-nav-item">
            <div class="pages-icon-bg">
                <svg viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/></svg>
            </div>
            <span>Invitaciones</span>
            @if($invitations->count() > 0)
                <span class="ml-auto bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $invitations->count() }}</span>
            @endif
        </div>
        
        {{-- 3. DESCUBRIR --}}
        <a href="{{ route('pages.index', ['view' => 'discover']) }}" class="pages-nav-item {{ $view === 'discover' ? 'active' : '' }}">
            <div class="pages-icon-bg">
                <svg viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M12 2.5a5.5 5.5 0 0 1 5.5 5.5c0 2.3-1.4 4.3-3.5 5.1v1.9h-4V13c-2.1-.8-3.5-2.8-3.5-5.1a5.5 5.5 0 0 1 5.5-5.5M12 1a7 7 0 0 0-7 7c0 2.7 1.6 5.1 4 6.3V19h6v-4.7c2.4-1.2 4-3.6 4-6.3a7 7 0 0 0-7-7z"/></svg>
            </div>
            Descubrir
        </a>

        <div class="border-t border-[#d3d6db] my-3 mx-2"></div>
        
        <div class="font-bold text-[16px] mb-2 px-2 text-[#65676b]">Tus páginas</div>
        
        @forelse($myPages as $page)
            <a href="{{ route('pages.show', $page->username) }}" class="pages-nav-item hover:no-underline">
                <img src="{{ $page->avatar }}" class="w-9 h-9 rounded-full border border-black/10 mr-3 object-cover">
                <div class="flex flex-col truncate">
                    <span class="text-[#050505] font-semibold text-sm truncate">{{ $page->name }}</span>
                    <span class="text-[11px] text-[#65676b] flex items-center gap-1 truncate">
                        {{ $page->category }}
                    </span>
                </div>
            </a>
        @empty
            <div class="px-2 text-xs text-gray-500">
                Aún no tienes páginas. ¡Crea una!
            </div>
        @endforelse

    </div>

    <div class="pages-content">
        
        <h2 class="text-lg font-bold text-[#050505] mb-3">{{ $title }}</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
            
            @forelse($feedPages as $page)
                <div class="page-card">
                    <a href="{{ route('pages.show', $page->username) }}" class="w-full">
                        <img src="{{ $page->cover }}" class="page-cover-preview">
                    </a>
                    
                    <a href="{{ route('pages.show', $page->username) }}">
                        <img src="{{ $page->avatar }}" class="page-avatar-preview">
                    </a>
                    
                    <a href="{{ route('pages.show', $page->username) }}" class="page-name hover:underline truncate w-full">
                        {{ $page->name }}
                    </a>
                    <div class="page-cat truncate w-full text-center px-2">{{ $page->category }}</div>
                    
                    <button class="btn-like-page">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"/></svg>
                        Me gusta
                    </button>
                </div>
            @empty
                <div class="col-span-full p-12 text-center text-gray-500 bg-white rounded border border-gray-200">
                    <div class="text-4xl mb-2">
                        @if($view === 'liked') 💔 @else 📡 @endif
                    </div>
                    <div class="text-lg font-bold">
                        @if($view === 'liked')
                            Aún no te gusta ninguna página.
                        @else
                            No se encontraron otras páginas.
                        @endif
                    </div>
                    <div class="text-sm mt-1">
                        @if($view === 'liked')
                            Ve a "Descubrir" para encontrar cosas interesantes.
                        @else
                            ¡Sé el primero en crear contenido popular!
                        @endif
                    </div>
                </div>
            @endforelse

        </div>

    </div>

</div>
@endsection