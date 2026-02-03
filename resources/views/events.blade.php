@extends('layouts.app')

@section('title', 'Eventos | Larabook')

@push('styles')
<style>
    /* Layout */
    .events-container {
        display: flex;
        height: calc(100vh - 42px);
        background-color: #f0f2f5;
    }

    /* Sidebar */
    .events-sidebar {
        width: 360px;
        background: white;
        border-right: 1px solid #d3d6db;
        padding: 16px;
        overflow-y: auto;
        flex-shrink: 0;
    }

    /* Contenido */
    .events-content {
        flex-grow: 1;
        padding: 24px 32px;
        overflow-y: auto;
    }

    /* Nav Items */
    .events-nav-item {
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
    .events-nav-item:hover { background-color: #f0f2f5; }
    .events-nav-item.active { background-color: #e7f3ff; color: #1877f2; }

    .events-icon-bg {
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
    .active .events-icon-bg { background: #1877f2; color: white; }

    /* Cards de Eventos (Lista Horizontal) */
    .event-card-list {
        background: white;
        border-radius: 8px;
        border: 1px solid #dddfe2;
        overflow: hidden;
        display: flex;
        margin-bottom: 12px;
        transition: box-shadow 0.2s;
    }
    .event-card-list:hover { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }

    .event-date-box {
        width: 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px;
        flex-shrink: 0;
    }
    .event-month { text-transform: uppercase; color: #fa3e3e; font-size: 11px; font-weight: bold; }
    .event-day { font-size: 20px; font-weight: bold; color: #1c1e21; }

    .event-cover-small {
        width: 130px;
        object-fit: cover;
    }

    .event-details { padding: 12px; flex-grow: 1; display: flex; flex-direction: column; justify-content: center; }
    .event-title { font-weight: bold; font-size: 16px; color: #050505; margin-bottom: 2px; }
    .event-time { font-size: 13px; color: #fa3e3e; margin-bottom: 2px; }
    .event-meta { font-size: 13px; color: #65676b; }

    .event-actions {
        display: flex;
        align-items: center;
        padding-right: 15px;
        gap: 10px;
    }
    .btn-event-outline {
        border: 1px solid #ccd0d5;
        background: #f5f6f7;
        padding: 6px 12px;
        font-weight: bold;
        font-size: 13px;
        color: #4b4f56;
        border-radius: 4px;
    }
    .btn-event-outline:hover { background: #e9ebee; }

    /* Cumpleaños */
    .birthday-card {
        background: white;
        border-radius: 8px;
        border: 1px solid #dddfe2;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="-mt-4 events-container">

    <div class="events-sidebar hidden md:block">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-[#050505]">Eventos</h1>
            <button class="bg-[#e4e6eb] w-9 h-9 rounded-full flex items-center justify-center hover:bg-[#d8dadf]">⚙️</button>
        </div>

        <button class="w-full bg-[#1877f2] hover:bg-[#166fe5] text-white font-bold py-2 rounded-md mb-4 flex items-center justify-center gap-2 border border-[#1877f2]">
            <span>+</span> Crear evento nuevo
        </button>
        
        <div class="events-nav-item active">
            <div class="events-icon-bg">🏠</div>
            Inicio
        </div>
        <div class="events-nav-item">
            <div class="events-icon-bg">👤</div>
            Tus eventos
        </div>
        <div class="events-nav-item">
            <div class="events-icon-bg">🎂</div>
            Cumpleaños
        </div>
        <div class="events-nav-item">
            <div class="events-icon-bg">🔍</div>
            Descubrir
        </div>
        
        <div class="border-t border-[#d3d6db] my-3 mx-2"></div>

        <div class="font-bold text-[16px] mb-2 px-2 text-[#65676b]">Calendarios</div>
        <div class="events-nav-item">
            <div class="events-icon-bg bg-transparent text-gray-500 border border-gray-300">📅</div>
            Mis calendarios
        </div>

    </div>

    <div class="events-content">
        
        <h2 class="text-lg font-bold text-[#050505] mb-3">Cumpleaños</h2>
        <div class="birthday-card">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-2xl">🎁</div>
            <div class="flex-grow">
                <div class="text-[15px] text-[#050505]">
                    <strong>Linus Torvalds</strong> y <strong>3 amigos más</strong> cumplen años hoy.
                </div>
                <div class="text-[13px] text-[#65676b]">¡Deséales lo mejor!</div>
            </div>
            <button class="bg-[#e4e6eb] hover:bg-[#d8dadf] text-[#050505] font-bold px-4 py-2 rounded-md text-sm">Escribir publicación</button>
        </div>

        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-bold text-[#050505]">Próximos eventos</h2>
            <a href="#" class="text-[#1877f2] text-sm hover:underline">Ver calendario</a>
        </div>

        <div class="event-card-list group cursor-pointer">
            <div class="event-date-box">
                <span class="event-month">FEB</span>
                <span class="event-day">14</span>
            </div>
            <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=300&auto=format&fit=crop" class="event-cover-small">
            <div class="event-details">
                <div class="event-time">SÁBADO, 14 DE FEBRERO A LAS 20:00</div>
                <div class="event-title group-hover:underline">Install Party: Debian 13 "Trixie" Pre-Alpha</div>
                <div class="event-meta">Casa de Miku Peluche · Organizado por Laravel Developers</div>
                <div class="event-meta mt-1 text-sm">23 amigos asistirán</div>
            </div>
            <div class="event-actions">
                <button class="btn-event-outline">☆ Me interesa</button>
                <button class="btn-event-outline">Asistiré</button>
            </div>
        </div>

        <div class="event-card-list group cursor-pointer">
            <div class="event-date-box">
                <span class="event-month">MAR</span>
                <span class="event-day">02</span>
            </div>
            <img src="https://kinsta.com/es/wp-content/uploads/sites/8/2020/02/laravel-framework.jpg" class="event-cover-small">
            <div class="event-details">
                <div class="event-time">MARTES, 2 DE MARZO A LAS 10:00</div>
                <div class="event-title group-hover:underline">Laracon Online 2026 Viewing Party</div>
                <div class="event-meta">Discord (Canal de Voz) · Público</div>
                <div class="event-meta mt-1 text-sm">1,204 personas interesadas</div>
            </div>
            <div class="event-actions">
                <button class="btn-event-outline">☆ Me interesa</button>
            </div>
        </div>

        <h2 class="text-lg font-bold text-[#050505] mb-3 mt-6">Sugerencias para ti</h2>
        
        <div class="event-card-list group cursor-pointer">
            <div class="event-date-box">
                <span class="event-month">ABR</span>
                <span class="event-day">20</span>
            </div>
            <img src="https://images.unsplash.com/photo-1574169208507-84376194878d?q=80&w=300&auto=format&fit=crop" class="event-cover-small">
            <div class="event-details">
                <div class="event-title group-hover:underline">Feria del Taco y la Computación</div>
                <div class="event-meta">Centro de Convenciones · Cerca de ti</div>
                <div class="event-meta mt-1 text-sm text-green-600">Amigos van a asistir</div>
            </div>
            <div class="event-actions">
                <button class="btn-event-outline">☆ Me interesa</button>
            </div>
        </div>

    </div>

</div>
@endsection