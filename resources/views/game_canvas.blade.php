@extends('layouts.app')

@section('title', 'Smash Friends | Larabook Games')

@push('styles')
<style>
    /* Contenedor principal del Canvas */
    .canvas-container {
        display: flex;
        height: calc(100vh - 42px); /* Altura total menos la barra azul */
        background-color: #e9ebee;
    }

    /* Área Principal del Juego (Izquierda) */
    .game-stage {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .game-header-bar {
        height: 50px;
        background: white;
        border-bottom: 1px solid #d3d6db;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 15px;
    }
    .game-header-title { font-size: 16px; font-weight: bold; color: #1c1e21; display: flex; align-items: center; gap: 10px; }
    .game-header-icon { width: 32px; height: 32px; border-radius: 4px; }

    /* El Iframe donde "vive" el juego */
    .game-iframe-wrapper {
        flex-grow: 1;
        background-color: #000; /* Fondo negro mientras carga */
        position: relative;
    }
    .game-iframe {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
        background-color: #f0f2f5; /* Fondo gris claro para el mensaje de error */
    }

    /* Barra Lateral Derecha (Chat y Actividad) */
    .game-sidebar-right {
        width: 300px;
        background: white;
        border-left: 1px solid #d3d6db;
        display: flex;
        flex-direction: column;
    }
    
    .sidebar-tab-bar { display: flex; border-bottom: 1px solid #dddfe2; background: #f5f6f7; }
    .sidebar-tab { flex: 1; text-align: center; padding: 10px 0; font-size: 13px; font-weight: bold; color: #4b4f56; cursor: pointer; }
    .sidebar-tab.active { color: #365899; border-bottom: 2px solid #365899; background: white; }

    .sidebar-content { flex-grow: 1; overflow-y: auto; padding: 10px; }
    
    .activity-item { display: flex; gap: 8px; font-size: 12px; margin-bottom: 12px; }
    .activity-user { font-weight: bold; color: #365899; }
    .activity-text { color: #1c1e21; }
</style>
@endpush

@section('content')
<div class="-mt-4 canvas-container">
    
    <div class="game-stage">
        <div class="game-header-bar">
            <div class="game-header-title">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR61yTaa8q3zC9C0M8aK-WqK1b4yC_X_yX8Xg&s" class="game-header-icon">
                Smash Friends
            </div>
            <div>
                <button class="bg-[#f5f6f7] hover:bg-[#e9ebee] text-[#4b4f56] font-bold text-xs px-3 py-1.5 rounded-[2px] border border-[#ccd0d5]">
                    📱 Enviar a celular
                </button>
                 <button class="ml-2 bg-[#f5f6f7] hover:bg-[#e9ebee] text-[#4b4f56] font-bold text-xs px-3 py-1.5 rounded-[2px] border border-[#ccd0d5]">
                    ⭐ Marcar como favorito
                </button>
            </div>
        </div>

        <div class="game-iframe-wrapper">
            <iframe src="/games/api-closed-message" class="game-iframe"></iframe>
        </div>
    </div>

    <div class="game-sidebar-right hidden lg:flex">
        <div class="sidebar-tab-bar">
            <div class="sidebar-tab active">Actividad</div>
            <div class="sidebar-tab">Chat</div>
        </div>
        
        <div class="sidebar-content">
            <div class="text-[11px] font-bold text-[#90949c] mb-2 uppercase">Ahora mismo</div>
            
            <div class="activity-item">
                <img src="https://ui-avatars.com/api/?name=Mark+Zuckerberg" class="w-8 h-8 rounded-full">
                <div>
                    <span class="activity-user">Mark Zuckerberg</span>
                    <span class="activity-text">ha cerrado el acceso a la API Graph v2.0.</span>
                </div>
            </div>
            <div class="activity-item">
                <img src="{{ Auth::user()->avatar }}" class="w-8 h-8 rounded-full">
                <div>
                    <span class="activity-user">{{ Auth::user()->first_name }}</span>
                    <span class="activity-text">está intentando jugar Smash Friends.</span>
                </div>
            </div>
             <div class="activity-item opacity-50">
                <div class="w-8 text-center text-xl">🔒</div>
                <div>
                    <span class="activity-text italic">El servicio de juegos no está disponible temporalmente por "mantenimiento de privacidad".</span>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection