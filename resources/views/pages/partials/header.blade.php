@push('styles')
<style>
    .page-header-container { background: white; border-bottom: 1px solid #d3d6db; }
    
    .cta-btn {
        padding: 6px 12px; font-weight: bold; font-size: 13px; border-radius: 2px;
        display: flex; align-items: center; gap: 6px; cursor: pointer; text-decoration: none;
    }
    .btn-blue { background-color: #4267b2; color: white; border: 1px solid #4267b2; }
    .btn-blue:hover { background-color: #365899; }
    .btn-gray { background-color: #f5f6f7; color: #4b4f56; border: 1px solid #ccd0d5; }
    .btn-gray:hover { background-color: #e9ebee; }
    
    .page-nav-item {
        padding: 0 16px; height: 100%; display: flex; align-items: center; 
        font-weight: bold; color: #4b4f56; font-size: 14px; cursor: pointer; border-bottom: 3px solid transparent; text-decoration: none;
    }
    .page-nav-item:hover { background-color: #f5f6f7; }
    .page-nav-item.active { border-bottom-color: #4267b2; color: #4b4f56; }
    
    .visitor-banner {
        background-color: #333; color: white; padding: 10px; text-align: center; font-size: 14px; position: sticky; top: 45px; z-index: 50;
    }
</style>
@endpush

{{-- 1. LÓGICA PHP PARA RUTAS Y ROLES --}}
@php
    // Verificar si soy el dueño
    $isAdmin = Auth::check() && Auth::id() === $page->user_id;
    
    // Verificar si activé el "Modo Visitante"
    $isViewingAsVisitor = $isAdmin && request('view_as') === 'visitor';
    
    // Decidir qué controles mostrar
    $showAdminControls = $isAdmin && !$isViewingAsVisitor;

    // --- AQUÍ ESTÁ LA SOLUCIÓN AL ERROR DE RUTA ---
    // Creamos un array con los parámetros obligatorios.
    // Usamos 'username' porque así lo definiste en tu Controller store() y en las Rutas
    $routeParams = ['username' => $page->username]; 
    
    // Si estamos en modo visitante, agregamos el parámetro a la URL para que persista al navegar
    if ($isViewingAsVisitor) {
        $routeParams['view_as'] = 'visitor';
    }
@endphp

{{-- 2. BANNER DE AVISO (Solo aparece en Modo Visitante) --}}
@if($isViewingAsVisitor)
    <div class="visitor-banner flex justify-center items-center gap-4">
        <span>👀 Estás viendo la página como visitante.</span>
        {{-- Enlace para volver a ser Admin --}}
        <a href="{{ route('pages.show', ['username' => $page->username]) }}" class="bg-gray-100 text-black px-3 py-1 rounded text-xs font-bold hover:bg-white text-decoration-none">
            Volver a Admin
        </a>
    </div>
@endif

{{-- 3. CABECERA VISUAL --}}
<div class="page-header-container shadow-sm mb-4 -mt-4 bg-white">
    <div class="max-w-[851px] mx-auto relative h-[360px]">
        
        <div class="h-[315px] w-full bg-gray-800 relative overflow-hidden group">
            <img src="{{ $page->cover }}" class="w-full h-full object-cover">
            
            <div class="absolute bottom-4 left-[200px]">
                <h1 class="text-white text-[30px] font-bold text-shadow drop-shadow-md flex items-center">
                    {{ $page->name }}
                    @if($page->is_verified ?? false) 
                        <span class="text-[#1877f2] bg-white rounded-full w-5 h-5 flex items-center justify-center text-[12px] ml-2" title="Verificado">✓</span> 
                    @endif
                </h1>
                <div class="text-white text-sm opacity-90 font-normal">{{ '@' . $page->username }}</div>
            </div>

            @if($showAdminControls)
                <button class="absolute top-4 left-4 bg-black/50 text-white text-xs font-bold px-3 py-1.5 rounded hidden group-hover:block transition">📷 Cambiar portada</button>
            @endif
        </div>

        <div class="absolute top-[230px] left-[15px] z-10 group">
            <div class="w-[160px] h-[160px] bg-white p-1 rounded-[2px] border border-gray-300 relative">
                 <img src="{{ $page->avatar }}" class="w-full h-full object-cover border border-black/10 bg-gray-50">
                 
                 @if($showAdminControls)
                    <div class="absolute bottom-0 left-0 w-full bg-black/50 text-white text-center text-xs py-1 opacity-0 group-hover:opacity-100 cursor-pointer transition">Actualizar</div>
                 @endif
            </div>
        </div>

        <div class="h-[45px] pl-[190px] flex items-center justify-between border-b border-[#d3d6db] bg-white">
            <div class="flex h-full">
                <a href="{{ route('pages.show', $routeParams) }}" class="page-nav-item {{ $active == 'home' ? 'active' : '' }}">
                    Inicio
                </a>
                
                <a href="{{ route('pages.about', $routeParams) }}" class="page-nav-item {{ $active == 'about' ? 'active' : '' }}">
                    Información
                </a>
                
                <a href="{{ route('pages.photos', $routeParams) }}" class="page-nav-item {{ $active == 'photos' ? 'active' : '' }}">
                    Fotos
                </a>
                
                <a href="#" class="page-nav-item">Me gusta</a>
            </div>

            <div class="flex gap-2 pr-4">
                @if($showAdminControls)
                    {{-- Controles de Dueño --}}
                    {{-- Este enlace agrega ?view_as=visitor a la URL actual --}}
                    <a href="{{ request()->fullUrlWithQuery(['view_as' => 'visitor']) }}" class="cta-btn btn-gray" title="Ver cómo luce tu página para el público">
                        👁️
                    </a>
                    <button class="cta-btn btn-gray">⚙️</button>
                    <button class="cta-btn btn-gray">✏️ Editar</button>
                @else
                    {{-- Controles de Visitante --}}
                    <button class="cta-btn btn-gray">👍 Te gusta</button>
                    <button class="cta-btn btn-blue">💬 Enviar mensaje</button>
                    <button class="cta-btn btn-gray px-2">...</button>
                @endif
            </div>
        </div>

    </div>
</div>