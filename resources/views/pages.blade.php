@extends('layouts.app')

@section('title', 'Páginas | Larabook')

@push('styles')
<style>
    /* Layout */
    .pages-container {
        display: flex;
        height: calc(100vh - 42px);
        background-color: #f0f2f5;
    }

    /* Sidebar */
    .pages-sidebar {
        width: 360px;
        background: white;
        border-right: 1px solid #d3d6db;
        padding: 16px;
        overflow-y: auto;
        flex-shrink: 0;
    }

    /* Contenido */
    .pages-content {
        flex-grow: 1;
        padding: 24px 32px;
        overflow-y: auto;
    }

    /* Botones Sidebar */
    .pages-nav-item {
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
    .pages-nav-item:hover { background-color: #f0f2f5; }
    .pages-nav-item.active { background-color: #e7f3ff; color: #1877f2; }

    .pages-icon-bg {
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
    .active .pages-icon-bg { background: #1877f2; color: white; }

    /* Cards de Páginas */
    .page-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #dddfe2;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-bottom: 12px;
    }
    
    .page-cover-preview { height: 80px; width: 100%; background: #333; object-fit: cover; }
    .page-avatar-preview { width: 60px; height: 60px; border-radius: 50%; border: 3px solid white; margin-top: -30px; background: white; object-fit: cover; }
    
    .page-name { font-weight: bold; font-size: 15px; color: #050505; margin-top: 5px; text-align: center; padding: 0 10px; }
    .page-cat { font-size: 12px; color: #65676b; margin-bottom: 10px; }

    .btn-like-page {
        background: #e4e6eb;
        color: #050505;
        font-weight: bold;
        padding: 6px 20px;
        border-radius: 6px;
        font-size: 14px;
        width: 80%;
        text-align: center;
    }
    .btn-like-page:hover { background: #d8dadf; }
</style>
@endpush

@section('content')
<div class="-mt-4 pages-container">

    <div class="pages-sidebar hidden md:block">
        <h1 class="text-2xl font-bold text-[#050505] mb-4">Páginas</h1>

        <button class="w-full bg-[#42b72a] hover:bg-[#36a420] text-white font-bold py-2 rounded-md mb-4 flex items-center justify-center gap-2 border border-[#29487d]">
            <span>+</span> Crear nueva página
        </button>
        
        <div class="pages-nav-item active">
            <div class="pages-icon-bg">🚩</div>
            Páginas que te gustan
        </div>
        <div class="pages-nav-item">
            <div class="pages-icon-bg">✉️</div>
            Invitaciones <span class="ml-auto bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">3</span>
        </div>
        <div class="pages-nav-item">
            <div class="pages-icon-bg">🚀</div>
            Descubrir
        </div>

        <div class="border-t border-[#d3d6db] my-3 mx-2"></div>
        
        <div class="font-bold text-[16px] mb-2 px-2 text-[#65676b]">Tus páginas</div>
        
        <a href="{{ route('page.show') }}" class="pages-nav-item hover:no-underline">
            <div class="w-9 h-9 rounded-full bg-[#4267b2] text-white flex items-center justify-center font-bold text-lg mr-3 select-none">l</div>
            <div class="flex flex-col">
                <span class="text-[#050505] font-semibold text-sm">Larabook Team</span>
                <span class="text-[11px] text-[#65676b] flex items-center gap-1">● 9+ notificaciones</span>
            </div>
        </a>

    </div>

    <div class="pages-content">
        
        <div class="mb-6">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-bold text-[#050505]">Invitaciones</h2>
                <a href="#" class="text-[#1877f2] text-sm hover:underline">Ver todas</a>
            </div>

            <div class="bg-white p-3 rounded-lg border border-[#dddfe2] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=DJ+Party&background=random" class="w-12 h-12 rounded-full">
                    <div>
                        <div class="text-sm"><strong>Mark Zuckerberg</strong> te invitó a indicar que te gusta <strong>DJ Zuck Metaverse Beats</strong>.</div>
                        <div class="text-xs text-[#65676b]">Música · 2 amigos en común</div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="bg-[#1877f2] hover:bg-[#166fe5] text-white px-6 py-1.5 rounded-md font-bold text-sm">Aceptar</button>
                    <button class="bg-[#e4e6eb] hover:bg-[#d8dadf] text-[#050505] px-6 py-1.5 rounded-md font-bold text-sm">Rechazar</button>
                </div>
            </div>
        </div>

        <h2 class="text-lg font-bold text-[#050505] mb-3">Sugerencias para ti</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
            
            <div class="page-card">
                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1000&auto=format&fit=crop" class="page-cover-preview">
                <img src="https://ui-avatars.com/api/?name=Laravel+News&background=ff2d20&color=fff" class="page-avatar-preview">
                <div class="page-name">Laravel News</div>
                <div class="page-cat">Noticias y medios</div>
                <button class="btn-like-page">👍 Me gusta</button>
            </div>

            <div class="page-card">
                <img src="https://images.unsplash.com/photo-1629654297299-c8506221ca97?q=80&w=1000&auto=format&fit=crop" class="page-cover-preview">
                <img src="https://ui-avatars.com/api/?name=Arch+Linux&background=1793d1&color=fff" class="page-avatar-preview">
                <div class="page-name">Arch Linux Users</div>
                <div class="page-cat">Comunidad</div>
                <button class="btn-like-page">👍 Me gusta</button>
            </div>

            <div class="page-card">
                <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?q=80&w=1000&auto=format&fit=crop" class="page-cover-preview">
                <img src="https://ui-avatars.com/api/?name=Mascotas&background=random" class="page-avatar-preview">
                <div class="page-name">Perritos Programadores</div>
                <div class="page-cat">Diversión</div>
                <button class="btn-like-page">👍 Me gusta</button>
            </div>

            <div class="page-card">
                <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=1000&auto=format&fit=crop" class="page-cover-preview">
                <img src="https://ui-avatars.com/api/?name=Hacker&background=000&color=fff" class="page-avatar-preview">
                <div class="page-name">CyberSecurity Tips</div>
                <div class="page-cat">Educación</div>
                <button class="btn-like-page">👍 Me gusta</button>
            </div>
             <div class="page-card">
                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=1000&auto=format&fit=crop" class="page-cover-preview">
                <img src="https://ui-avatars.com/api/?name=Code&background=purple&color=fff" class="page-avatar-preview">
                <div class="page-name">100 Days Of Code</div>
                <div class="page-cat">Reto</div>
                <button class="btn-like-page">👍 Me gusta</button>
            </div>

        </div>

        <div class="text-center mt-6">
            <button class="text-[#1877f2] font-semibold hover:underline">Ver más sugerencias</button>
        </div>

    </div>

</div>
@endsection