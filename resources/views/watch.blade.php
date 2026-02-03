@extends('layouts.app')

@section('title', 'Watch | Larabook')

@push('styles')
<style>
    /* Layout de 2 columnas fluido */
    .watch-container {
        display: flex;
        height: calc(100vh - 42px);
        overflow: hidden;
    }

    /* Sidebar específico de Watch (Blanco y fijo) */
    .watch-sidebar {
        width: 360px;
        background: white;
        border-right: 1px solid #d3d6db;
        overflow-y: auto;
        padding-bottom: 20px;
        flex-shrink: 0;
    }

    /* Área principal oscura (Cine) */
    .watch-content {
        flex-grow: 1;
        background-color: #f0f2f5; /* En 2018 ya usaban este gris suave, a veces negro en modo teatro */
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Estilos del Sidebar */
    .watch-nav-item {
        display: flex;
        align-items: center;
        padding: 8px 10px;
        margin: 0 8px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
        color: #050505;
    }
    .watch-nav-item:hover { background-color: #f0f2f5; }
    .watch-nav-item.active { background-color: #e4e6eb; color: #1877f2; }
    
    .watch-icon-bg {
        width: 36px;
        height: 36px;
        background: #e4e6eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 20px;
    }
    .active .watch-icon-bg { background: #1877f2; color: white; }

    /* Video Card */
    .video-card {
        background: white;
        width: 100%;
        max-width: 850px; /* Ancho máximo para videos */
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }

    /* FALSO REPRODUCTOR DE VIDEO */
    .fake-player {
        width: 100%;
        aspect-ratio: 16/9;
        background-color: black;
        position: relative;
        cursor: pointer;
        group;
    }
    .fake-player:hover .player-controls { opacity: 1; }
    
    .play-button-overlay {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 70px; height: 70px;
        background: rgba(0,0,0,0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
        transition: transform 0.2s;
    }
    .fake-player:hover .play-button-overlay { transform: translate(-50%, -50%) scale(1.1); }

    .player-controls {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        display: flex;
        align-items: center;
        padding: 0 15px;
        opacity: 0; /* Se oculta si no haces hover */
        transition: opacity 0.3s;
    }

    .progress-bar { flex-grow: 1; height: 4px; background: rgba(255,255,255,0.3); border-radius: 2px; margin: 0 15px; position: relative; }
    .progress-fill { width: 35%; height: 100%; background: #1877f2; position: relative; }
    .progress-thumb { position: absolute; right: -6px; top: -3px; width: 10px; height: 10px; background: white; border-radius: 50%; }

    /* Etiquetas en el video (LIVE, 360, etc) */
    .video-badge {
        position: absolute;
        top: 15px; left: 15px;
        background: rgba(0,0,0,0.6);
        color: white;
        padding: 2px 6px;
        font-size: 11px;
        font-weight: bold;
        border-radius: 2px;
        text-transform: uppercase;
    }
    .badge-live { background: #e41e3f; }
</style>
@endpush

@section('content')
<div class="-mt-4 watch-container">
    
    <div class="watch-sidebar hidden md:block">
        <div class="p-4">
            <h1 class="text-2xl font-bold text-[#050505] mb-4">Watch</h1>
            
            <div class="relative mb-4">
                <span class="absolute left-3 top-2.5 text-gray-500">🔍</span>
                <input type="text" placeholder="Buscar videos" class="w-full bg-[#f0f2f5] border-none rounded-full py-2 pl-10 pr-4 text-[15px] outline-none focus:ring-1 focus:ring-gray-300">
            </div>
        </div>

        <div class="watch-nav-item active">
            <div class="watch-icon-bg">📺</div>
            Inicio
        </div>
        <div class="watch-nav-item">
            <div class="watch-icon-bg">🎬</div>
            Programas
        </div>
        <div class="watch-nav-item">
            <div class="watch-icon-bg">🔴</div>
            En vivo
        </div>
        <div class="watch-nav-item">
            <div class="watch-icon-bg">🔖</div>
            Videos guardados
        </div>

        <div class="border-t border-[#d3d6db] my-4 mx-4"></div>
        
        <div class="px-4 mb-2 flex justify-between items-center">
            <span class="text-[16px] font-bold text-gray-600">Tu lista</span>
            <a href="#" class="text-[#1877f2] text-sm hover:underline">Administrar</a>
        </div>

        <div class="watch-nav-item">
            <img src="https://ui-avatars.com/api/?name=Larabook+Originals&background=ff0000&color=fff" class="w-9 h-9 rounded-full mr-3">
            <div class="text-sm">
                <div class="font-bold line-clamp-1">Larabook Originals</div>
                <div class="text-xs text-[#1877f2] flex items-center gap-1">● 3 videos nuevos</div>
            </div>
        </div>
        <div class="watch-nav-item">
            <img src="https://ui-avatars.com/api/?name=PHP+Hacks" class="w-9 h-9 rounded-full mr-3">
            <div class="text-sm font-bold">PHP Hacks</div>
        </div>
    </div>

    <div class="watch-content">
        
        <div class="video-card">
            <div class="p-4 flex justify-between items-start">
                <div class="flex gap-3">
                    <img src="https://ui-avatars.com/api/?name=Larabook+Gaming" class="w-10 h-10 rounded-full border border-gray-200">
                    <div>
                        <div class="font-bold text-[#050505] text-[15px]">
                            Larabook Gaming <span class="text-[#1877f2]">was live.</span>
                        </div>
                        <div class="text-xs text-gray-500">
                            Hace 3 horas · 🌎
                        </div>
                    </div>
                </div>
                <button class="text-gray-500 font-bold text-xl hover:bg-gray-100 rounded-full w-8 h-8">...</button>
            </div>

            <div class="px-4 pb-2 text-[15px] text-[#050505]">
                Intentando compilar el kernel de Linux en una tostadora 🍞🐧 <span class="text-[#1877f2]">#Linux #Gaming #Fail</span>
            </div>

            <div class="fake-player group">
                <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover opacity-80">
                
                <div class="video-badge badge-live">GRABACIÓN EN VIVO</div>
                
                <div class="play-button-overlay">
                    <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" /></svg>
                </div>

                <div class="player-controls">
                    <button class="text-white mr-2">▶</button> <button class="text-white mr-2">🔊</button> <div class="text-white text-xs">12:34 / 45:00</div>
                    
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                        <div class="progress-thumb"></div>
                    </div>
                    
                    <button class="text-white ml-2">⚙️</button> <button class="text-white ml-2">⛶</button> </div>
            </div>

            <div class="p-3 border-t border-gray-200">
                <div class="flex justify-between items-center text-sm text-gray-500 mb-3 border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-1">
                        <span>😆 😮 👍 3.4 mil</span>
                    </div>
                    <div>
                        502 comentarios · 120 veces compartido · 230 mil reproducciones
                    </div>
                </div>
                <div class="flex text-gray-600 font-bold text-[14px]">
                    <div class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 rounded cursor-pointer">👍 Me gusta</div>
                    <div class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 rounded cursor-pointer">💬 Comentar</div>
                    <div class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 rounded cursor-pointer">🔄 Compartir</div>
                </div>
            </div>
        </div>

        <div class="video-card">
            <div class="p-4 flex gap-3 mb-1">
                <img src="https://ui-avatars.com/api/?name=Tasty+Clone" class="w-10 h-10 rounded-full border border-gray-200">
                <div>
                    <div class="font-bold text-[#050505]">
                        Tasty Clone <span class="text-[#1877f2] text-xs">✓ Seguir</span>
                    </div>
                    <div class="text-xs text-gray-500">Ayer a las 14:00 · 🌎</div>
                </div>
            </div>
            <div class="px-4 pb-2 text-[15px]">
                ¡Aprende a cocinar espagueti de código en 5 minutos! 🍝👨‍💻
            </div>
            <div class="fake-player">
                <img src="https://images.unsplash.com/photo-1476718406336-bb5a9690ee2a?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover opacity-90">
                <div class="video-badge bottom-4 right-4 top-auto left-auto">05:23</div>
                 <div class="play-button-overlay">
                    <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" /></svg>
                </div>
            </div>
             <div class="p-3">
                 <div class="flex items-center gap-2 text-sm text-gray-500">
                     <span>❤️ 10 mil</span> · <span>2.4 M reproducciones</span>
                 </div>
                 <div class="flex gap-2 mt-3">
                     <button class="bg-gray-100 hover:bg-gray-200 px-4 py-1 rounded-full text-sm font-bold text-gray-700">👍 Me gusta</button>
                     <button class="bg-gray-100 hover:bg-gray-200 px-4 py-1 rounded-full text-sm font-bold text-gray-700">💬 Comentar</button>
                 </div>
            </div>
        </div>

    </div>

</div>
@endsection