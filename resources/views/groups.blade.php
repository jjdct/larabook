@extends('layouts.app')

@section('title', 'Grupos | Larabook')

@push('styles')
<style>
    /* Layout */
    .groups-container {
        display: flex;
        height: calc(100vh - 42px);
        background-color: #f0f2f5;
    }

    /* Sidebar */
    .groups-sidebar {
        width: 360px;
        background: white;
        border-right: 1px solid #d3d6db;
        padding: 16px;
        overflow-y: auto;
        flex-shrink: 0;
    }

    /* Contenido */
    .groups-content {
        flex-grow: 1;
        padding: 24px 32px;
        overflow-y: auto;
    }

    /* Nav Items */
    .groups-nav-item {
        display: flex;
        align-items: center;
        padding: 8px 10px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
        color: #050505;
        margin-bottom: 2px;
    }
    .groups-nav-item:hover { background-color: #f0f2f5; }
    .groups-nav-item.active { background-color: #e7f3ff; color: #1877f2; }

    .groups-icon-bg {
        width: 36px;
        height: 36px;
        background: #e4e6eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 18px;
    }
    .active .groups-icon-bg { background: #1877f2; color: white; }

    /* Group Cards (Grid) */
    .group-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #dddfe2;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }
    
    .group-cover-preview { height: 100px; width: 100%; object-fit: cover; }
    
    .group-info { padding: 12px; flex-grow: 1; }
    .group-name { font-weight: bold; font-size: 16px; color: #050505; margin-bottom: 4px; line-height: 1.2; }
    .group-members { font-size: 12px; color: #65676b; }

    .btn-join-group {
        width: 100%;
        background: #e7f3ff;
        color: #1877f2;
        font-weight: bold;
        padding: 8px 0;
        border-radius: 6px;
        font-size: 14px;
        margin-top: 10px;
        border: none;
        transition: background 0.2s;
    }
    .btn-join-group:hover { background: #dbe7f2; }

    /* Feed rápido de actividad de grupos */
    .group-feed-item {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dddfe2;
        margin-bottom: 12px;
    }
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
        <div class="groups-nav-item">
            <div class="groups-icon-bg">➕</div>
            Crear nuevo grupo
        </div>

        <div class="border-t border-[#d3d6db] my-3 mx-2"></div>
        
        <div class="font-bold text-[16px] mb-2 px-2 text-[#65676b]">Tus grupos</div>
        
        <a href="{{ route('group.show') }}" class="groups-nav-item hover:no-underline">
            <img src="https://kinsta.com/es/wp-content/uploads/sites/8/2020/02/laravel-framework.jpg" class="w-9 h-9 rounded-md mr-3 object-cover">
            <div class="flex flex-col">
                <span class="text-[#050505] font-semibold text-sm line-clamp-1">Laravel Developers & Linux</span>
                <span class="text-[11px] text-[#1877f2] font-bold">● 2 publicaciones nuevas</span>
            </div>
        </a>

        <div class="groups-nav-item">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/Tux.svg/1200px-Tux.svg.png" class="w-9 h-9 rounded-md mr-3 object-contain bg-gray-100 px-1">
            <div class="flex flex-col">
                <span class="text-[#050505] font-semibold text-sm">Debian Users Official</span>
            </div>
        </div>

         <div class="groups-nav-item">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Miku_Hatsune.jpg/250px-Miku_Hatsune.jpg" class="w-9 h-9 rounded-md mr-3 object-cover">
            <div class="flex flex-col">
                <span class="text-[#050505] font-semibold text-sm">Vocaloid Fans México</span>
            </div>
        </div>

    </div>

    <div class="groups-content">
        
        <div class="mb-6">
            <h2 class="text-lg font-bold text-[#050505] mb-3">Actividad reciente</h2>
            
            <div class="group-feed-item">
                <div class="flex items-center gap-2 mb-2">
                    <img src="https://kinsta.com/es/wp-content/uploads/sites/8/2020/02/laravel-framework.jpg" class="w-6 h-6 rounded-md object-cover">
                    <span class="font-bold text-sm text-[#050505]">Laravel Developers & Linux Users</span>
                    <span class="text-xs text-gray-500">• Hace 20 min</span>
                </div>
                <div class="flex gap-3">
                    <img src="https://ui-avatars.com/api/?name=Taylor+Otwell&background=ff2d20&color=fff" class="w-10 h-10 rounded-full border border-gray-200">
                    <div>
                        <div class="font-bold text-sm text-[#050505]">Taylor Otwell</div>
                        <p class="text-sm text-[#050505] mt-1">¿Alguien ha probado correr Laravel 12 en un Chromebook con Debian? Necesito testers para el nuevo instalador.</p>
                        
                        <div class="flex gap-4 mt-3 text-sm text-[#65676b] font-bold">
                            <span class="cursor-pointer hover:underline">Me gusta</span>
                            <span class="cursor-pointer hover:underline">Comentar</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group-feed-item">
                <div class="flex items-center gap-2 mb-2">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/Tux.svg/1200px-Tux.svg.png" class="w-6 h-6 rounded-md object-contain">
                    <span class="font-bold text-sm text-[#050505]">Debian Users Official</span>
                    <span class="text-xs text-gray-500">• Hace 1 hora</span>
                </div>
                <p class="text-sm text-[#050505]">Recordatorio semanal: `sudo apt update && sudo apt upgrade` salva vidas. No sean como los usuarios de Arch que rompen su sistema cada viernes. 🐧</p>
            </div>
        </div>

        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-bold text-[#050505]">Sugerencias para ti</h2>
            <a href="#" class="text-[#1877f2] text-sm hover:underline">Ver todo</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
            
            <div class="group-card">
                <div>
                    <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=1000&auto=format&fit=crop" class="group-cover-preview">
                    <div class="group-info">
                        <div class="group-name">Programadores que odian Windows</div>
                        <div class="group-members">245 mil miembros · 10 publicaciones al día</div>
                    </div>
                </div>
                <div class="p-3 pt-0">
                    <button class="btn-join-group">Unirte al grupo</button>
                </div>
            </div>

            <div class="group-card">
                <div>
                    <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?q=80&w=1000&auto=format&fit=crop" class="group-cover-preview">
                    <div class="group-info">
                        <div class="group-name">Vim Users (Exit is blocked)</div>
                        <div class="group-members">12 mil miembros · 2 publicaciones al día</div>
                    </div>
                </div>
                <div class="p-3 pt-0">
                    <button class="btn-join-group">Unirte al grupo</button>
                </div>
            </div>

            <div class="group-card">
                <div>
                    <img src="https://images.unsplash.com/photo-1614332287897-cdc485fa562d?q=80&w=1000&auto=format&fit=crop" class="group-cover-preview">
                    <div class="group-info">
                        <div class="group-name">Larabook Beta Testers</div>
                        <div class="group-members">3 miembros · Grupo secreto</div>
                    </div>
                </div>
                <div class="p-3 pt-0">
                    <button class="btn-join-group">Unirte al grupo</button>
                </div>
            </div>

            <div class="group-card">
                <div>
                    <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=1000&auto=format&fit=crop" class="group-cover-preview">
                    <div class="group-info">
                        <div class="group-name">PC Gaming on Linux (Proton)</div>
                        <div class="group-members">56 mil miembros · 100 publicaciones al día</div>
                    </div>
                </div>
                <div class="p-3 pt-0">
                    <button class="btn-join-group">Unirte al grupo</button>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection