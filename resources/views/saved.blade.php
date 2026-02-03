@extends('layouts.app')

@section('title', 'Guardado | Larabook')

@push('styles')
<style>
    /* Layout */
    .saved-container {
        display: flex;
        height: calc(100vh - 42px);
        background-color: #f0f2f5;
    }

    /* Sidebar */
    .saved-sidebar {
        width: 360px;
        background: white;
        border-right: 1px solid #d3d6db;
        padding: 16px;
        overflow-y: auto;
        flex-shrink: 0;
    }

    /* Contenido */
    .saved-content {
        flex-grow: 1;
        padding: 24px 32px;
        overflow-y: auto;
    }

    /* Nav Items */
    .saved-nav-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
        color: #050505;
        margin-bottom: 4px;
    }
    .saved-nav-item:hover { background-color: #f0f2f5; }
    .saved-nav-item.active { background-color: #e7f3ff; color: #1877f2; }

    .saved-icon-bg {
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
    .active .saved-icon-bg { background: #1877f2; color: white; }

    /* Saved Cards */
    .saved-card {
        background: white;
        border-radius: 8px;
        border: 1px solid #dddfe2;
        overflow: hidden;
        display: flex;
        margin-bottom: 12px;
        padding: 12px;
        transition: box-shadow 0.2s;
        cursor: pointer;
        position: relative;
    }
    .saved-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }

    .saved-thumb {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid rgba(0,0,0,0.1);
        flex-shrink: 0;
    }

    .saved-info {
        padding-left: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .saved-category { font-size: 12px; text-transform: uppercase; color: #65676b; font-weight: bold; margin-bottom: 4px; }
    .saved-title { font-size: 18px; font-weight: bold; color: #050505; margin-bottom: 4px; line-height: 1.2; }
    .saved-meta { font-size: 13px; color: #65676b; display: flex; align-items: center; gap: 6px; }
    
    .saved-origin-img { width: 20px; height: 20px; border-radius: 4px; }

    .saved-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-action-light {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 1px solid #dddfe2;
        cursor: pointer;
    }
    .btn-action-light:hover { background: #f0f2f5; }

    .btn-add-collection {
        background: #e7f3ff;
        color: #1877f2;
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 14px;
        border: none;
    }
    .btn-add-collection:hover { background: #dbe7f2; }
</style>
@endpush

@section('content')
<div class="-mt-4 saved-container">

    <div class="saved-sidebar hidden md:block">
        <h1 class="text-2xl font-bold text-[#050505] mb-4">Guardado</h1>

        <div class="saved-nav-item active">
            <div class="saved-icon-bg">📑</div>
            Todos los elementos
        </div>
        
        <div class="border-t border-[#d3d6db] my-3 mx-2"></div>
        
        <div class="font-bold text-[16px] mb-2 px-2 text-[#65676b]">Tus colecciones</div>
        
        <div class="saved-nav-item">
            <div class="saved-icon-bg bg-transparent border border-gray-300">🐧</div>
            Linux & Dev
        </div>
        <div class="saved-nav-item">
            <div class="saved-icon-bg bg-transparent border border-gray-300">🥘</div>
            Recetas para la semana
        </div>
        <div class="saved-nav-item">
            <div class="saved-icon-bg bg-transparent border border-gray-300">🎵</div>
            Música pendiente
        </div>

        <button class="w-full bg-[#e7f3ff] text-[#1877f2] font-bold py-2 rounded-md mt-4 hover:bg-[#dbe7f2]">
            + Crear colección nueva
        </button>

    </div>

    <div class="saved-content">
        
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-[#050505]">Todo</h2>
            <button class="text-[#1877f2] text-sm hover:underline">Configuración</button>
        </div>

        <div class="saved-card group">
            <img src="https://images.unsplash.com/photo-1629654297299-c8506221ca97?q=80&w=300&auto=format&fit=crop" class="saved-thumb">
            <div class="saved-info">
                <div class="saved-category">Enlace</div>
                <div class="saved-title group-hover:underline">How to exit Vim: A comprehensive guide for beginners</div>
                <div class="saved-meta">
                    <img src="https://stackoverflow.design/assets/img/logos/so/logo-icon.png" class="saved-origin-img">
                    Guardado desde <strong>Stack Overflow</strong> · Hace 2 días
                </div>
            </div>
            <div class="saved-actions">
                <button class="btn-add-collection">Agregar a colección</button>
                <button class="btn-action-light">...</button>
            </div>
        </div>

        <div class="saved-card group">
            <img src="https://images.unsplash.com/photo-1544652478-6653e09f9039?q=80&w=300&auto=format&fit=crop" class="saved-thumb">
            <div class="saved-info">
                <div class="saved-category">Marketplace</div>
                <div class="saved-title group-hover:underline">Lenovo ThinkPad X220 (Perfecta para Linux)</div>
                <div class="saved-meta font-bold text-black">
                    $3,500 MXN · Vendedor: Richard Stallman
                </div>
                <div class="saved-meta mt-1">
                    Guardado de Marketplace · Hace 1 semana
                </div>
            </div>
            <div class="saved-actions">
                <button class="btn-action-light text-[#1877f2] bg-[#e7f3ff] border-transparent">💬</button>
                <button class="btn-action-light">...</button>
            </div>
        </div>

        <div class="saved-card group">
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=300&auto=format&fit=crop" class="saved-thumb brightness-75">
                <div class="absolute inset-0 flex items-center justify-center text-white text-3xl">▶</div>
            </div>
            <div class="saved-info">
                <div class="saved-category">Video</div>
                <div class="saved-title group-hover:underline">Why NVIDIA is bad for Open Source (Linus Rant)</div>
                <div class="saved-meta">
                    <img src="https://ui-avatars.com/api/?name=Larabook+Watch&background=red&color=fff" class="saved-origin-img">
                    Guardado desde <strong>Larabook Watch</strong> · Hace 3 semanas
                </div>
            </div>
            <div class="saved-actions">
                <button class="btn-add-collection">Agregar a colección</button>
                <button class="btn-action-light">...</button>
            </div>
        </div>

        <div class="saved-card group">
            <img src="https://ui-avatars.com/api/?name=Taylor+Otwell&background=ff2d20&color=fff" class="saved-thumb object-contain p-2">
            <div class="saved-info">
                <div class="saved-category">Publicación</div>
                <div class="saved-title group-hover:underline">La publicación de Taylor Otwell</div>
                <div class="saved-meta text-sm italic text-gray-800 mb-1">
                    "Just shipped Laravel 12. It now writes the code for you while you sleep."
                </div>
                <div class="saved-meta">
                    Guardado desde su biografía · Hace 1 mes
                </div>
            </div>
            <div class="saved-actions">
                <button class="btn-add-collection">Agregar a colección</button>
                <button class="btn-action-light">...</button>
            </div>
        </div>

    </div>

</div>
@endsection