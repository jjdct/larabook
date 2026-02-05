@extends('layouts.app')

@section('title', 'Inicio | Larabook')

@push('styles')
<style>
    /* === ESTILOS GLOBALES DEL FEED === */
    
    /* 1. Historias (Stories) */
    .stories-container { display: flex; gap: 8px; margin-bottom: 16px; overflow-x: auto; padding-bottom: 5px; }
    .stories-container::-webkit-scrollbar { height: 0px; background: transparent; }

    .story-card { width: 110px; height: 200px; position: relative; border-radius: 8px; overflow: hidden; cursor: pointer; flex-shrink: 0; box-shadow: 0 1px 2px rgba(0,0,0,0.1); transition: transform 0.2s; }
    .story-card:hover { transform: scale(1.02); }
    .story-bg { width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s; }
    .story-card:hover .story-bg { opacity: 0.9; }
    
    .story-avatar { position: absolute; top: 10px; left: 10px; width: 40px; height: 40px; border-radius: 50%; border: 4px solid #1877f2; object-fit: cover; z-index: 2; }
    .story-name { position: absolute; bottom: 10px; left: 10px; color: white; font-weight: bold; font-size: 13px; text-shadow: 0 1px 2px rgba(0,0,0,0.6); z-index: 2; }
    .story-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0,0,0,0) 70%, rgba(0,0,0,0.4)); }
    
    /* Add Story Card */
    .add-story-card .story-bg { height: 60%; object-fit: cover; }
    .add-story-bottom { height: 40%; background: white; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; padding-bottom: 10px; }
    .add-story-btn { background: #1877f2; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold; position: absolute; top: 55%; border: 3px solid white; }

    /* 2. Iconos Sidebar */
    .left-nav-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; }

    /* 3. Sidebar Derecho */
    .right-sidebar { width: 280px; position: fixed; right: 0; top: 42px; bottom: 0; padding: 10px; overflow-y: auto; display: none; }
    @media (min-width: 1100px) { .right-sidebar { display: block; } }

    .contact-item { display: flex; align-items: center; padding: 8px; border-radius: 6px; cursor: pointer; }
    .contact-item:hover { background-color: rgba(0,0,0,0.05); }
    .contact-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; position: relative; }
    .contact-status { width: 10px; height: 10px; background: #31a24c; border-radius: 50%; position: absolute; bottom: 0; right: 0; border: 2px solid white; }
</style>
@endpush

@section('content')
<div class="flex justify-center gap-4 relative">
    
    <div class="w-[280px] hidden lg:block sticky top-[50px] self-start h-[calc(100vh-50px)] overflow-y-auto pl-2">
        
        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <img src="{{ Auth::user()->avatar }}" class="w-8 h-8 rounded-full border border-black/10">
            {{ Auth::user()->name }}
        </a>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <div class="left-nav-icon bg-gradient-to-br from-blue-400 to-blue-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/></svg>
            </div>
            News Feed
        </a>

        <a href="#" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <div class="left-nav-icon bg-gradient-to-br from-blue-500 to-pink-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12c0 2.17.72 4.19 1.95 5.82L3 22l4.38-1.16C8.79 21.57 10.35 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg>
            </div>
            Larassenger
        </a>

        <a href="{{ route('groups.index') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <div class="left-nav-icon bg-gradient-to-br from-blue-400 to-cyan-500 border border-blue-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            Grupos
        </a>

        <a href="{{ route('pages.index') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <div class="left-nav-icon bg-orange-500">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14.4 6L14 4H5v17h2v-7h5.6l.4 2h7V6z"/></svg>
            </div>
            Páginas
        </a>

        <a href="#" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <div class="left-nav-icon bg-gradient-to-br from-blue-400 to-blue-600 border border-blue-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14zM8 15c0-1.66 1.34-3 3-3 .35 0 .69.07 1 .18V6h5v2h-3v7.03c-.02 1.64-1.35 2.97-3 2.97-1.66 0-3-1.34-3-3z"/></svg>
            </div>
            Watch
        </a>

        <a href="#" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <div class="left-nav-icon bg-gradient-to-br from-blue-400 to-blue-600">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
            </div>
            Recuerdos
        </a>

        <div class="border-b my-2"></div>
        <div class="px-2 font-bold text-[#65676b] mb-2">Accesos directos</div>
        <a href="{{ route('groups.index') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#65676b]">
            <div class="w-8 h-8 rounded bg-gray-200 flex items-center justify-center text-xs">🔍</div>
            Buscar grupos
        </a>
    </div>

    <div class="w-full md:w-[590px]">
        
        <div class="stories-container">
            <div class="story-card add-story-card bg-white border border-gray-200">
                <img src="{{ Auth::user()->avatar }}" class="story-bg">
                <div class="add-story-btn">+</div>
                <div class="add-story-bottom"><span class="text-xs font-bold text-gray-800">Crear historia</span></div>
            </div>
            </div>

        <div class="card p-3 mb-4">
            <div class="flex gap-2 border-b border-[#e9eaed] pb-3 mb-2">
                <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full border border-black/10">
                <div class="bg-[#f0f2f5] hover:bg-[#e4e6eb] rounded-full flex-grow py-2 px-3 text-[#65676b] font-normal text-[15px] cursor-pointer">
                    ¿Qué estás pensando, {{ Auth::user()->first_name }}?
                </div>
            </div>
            <div class="flex justify-between px-2 pt-1">
                <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded w-1/3 justify-center">
                    <span class="text-red-500 font-bold text-xl">🎥</span><span class="text-[14px] font-semibold text-[#65676b]">Video en vivo</span>
                </div>
                <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded w-1/3 justify-center">
                    <span class="text-green-500 font-bold text-xl">📷</span><span class="text-[14px] font-semibold text-[#65676b]">Foto/video</span>
                </div>
                <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded w-1/3 justify-center">
                    <span class="text-yellow-500 font-bold text-xl">😊</span><span class="text-[14px] font-semibold text-[#65676b]">Sentimiento</span>
                </div>
            </div>
        </div>

        @forelse($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <div class="bg-white p-8 rounded-lg text-center text-gray-500 shadow border border-gray-200">
                <div class="text-5xl mb-3">📰</div>
                <h3 class="text-xl font-bold text-gray-700">Tu Feed está vacío</h3>
                <p class="text-sm mt-2 mb-4">
                    Parece que no hay actividad reciente. <br>
                    ¡Únete a grupos, crea una página o publica algo tú mismo!
                </p>
                <div class="flex justify-center gap-2">
                    <a href="{{ route('groups.index') }}" class="text-blue-600 font-bold hover:underline">Explorar grupos</a>
                    <span>·</span>
                    <a href="{{ route('pages.index') }}" class="text-blue-600 font-bold hover:underline">Ver páginas</a>
                </div>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $posts->links() }}
        </div>

    </div>

    <div class="right-sidebar hidden lg:block">
        <div class="mb-4">
            <div class="text-[#65676b] font-semibold text-[13px] mb-2">Publicidad</div>
            <div class="flex gap-3 mb-2 cursor-pointer group">
                <img src="https://kinsta.com/es/wp-content/uploads/sites/8/2020/02/laravel-framework.jpg" class="w-[100px] h-[70px] object-cover rounded group-hover:opacity-90">
                <div>
                    <div class="text-[#050505] font-semibold text-[13px] leading-tight group-hover:underline">Domina Laravel 12</div>
                    <div class="text-[#65676b] text-[12px]">laracasts.com</div>
                </div>
            </div>
        </div>

        <div class="border-t border-[#ced0d4] my-2"></div>

        <div class="mb-4">
            <div class="text-[#65676b] font-semibold text-[13px] mb-2">Cumpleaños</div>
            <div class="flex gap-2 items-center cursor-pointer hover:bg-gray-100 p-1 rounded">
                <img src="https://static.xx.fbcdn.net/rsrc.php/v3/yA/r/8hF5374Bq5R.png" class="w-6 h-6">
                <div class="text-[#050505] text-[13px]">
                    <strong>Mark Zuckerberg</strong> cumple años hoy.
                </div>
            </div>
        </div>

        <div class="border-t border-[#ced0d4] my-2"></div>

        <div>
            <div class="flex justify-between items-center mb-2">
                <div class="text-[#65676b] font-semibold text-[13px]">Contactos</div>
                <div class="text-[#65676b] cursor-pointer">🔍</div>
            </div>
            
            @forelse($contacts as $contact)
                <div class="contact-item">
                    <div class="relative mr-3">
                        <img src="{{ $contact->avatar }}" class="contact-avatar">
                        <div class="contact-status"></div>
                    </div>
                    <div class="text-[#050505] font-semibold text-[13px]">{{ $contact->name }}</div>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-500 italic">
                    No hay contactos conectados.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection