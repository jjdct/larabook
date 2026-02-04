@extends('layouts.app')

@section('title', 'Facebook')

@push('styles')
<style>
    /* Estilos de Historias (Stories) */
    .stories-container {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;
        overflow-x: auto;
    }
    .story-card {
        width: 110px;
        height: 200px;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        flex-shrink: 0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .story-card:hover { transform: scale(1.02); }
    .story-bg { width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s; }
    .story-card:hover .story-bg { opacity: 0.9; }
    
    .story-avatar {
        position: absolute;
        top: 10px; left: 10px;
        width: 40px; height: 40px;
        border-radius: 50%;
        border: 4px solid #1877f2;
        object-fit: cover;
        z-index: 2;
    }
    .story-name {
        position: absolute;
        bottom: 10px; left: 10px;
        color: white;
        font-weight: bold;
        font-size: 13px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.6);
        z-index: 2;
    }
    .story-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 70%, rgba(0,0,0,0.4));
    }

    /* Add Story Card (La primera) */
    .add-story-card .story-bg { height: 60%; object-fit: cover; }
    .add-story-bottom {
        height: 40%; background: white;
        display: flex; flex-direction: column; align-items: center; justify-content: flex-end; padding-bottom: 10px;
    }
    .add-story-btn {
        background: #1877f2; color: white; border-radius: 50%; width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold;
        position: absolute; top: 55%; border: 3px solid white;
    }

    /* Right Sidebar (Contactos) */
    .right-sidebar {
        width: 280px;
        position: fixed;
        right: 0;
        top: 42px; /* Altura navbar */
        bottom: 0;
        padding: 10px;
        overflow-y: auto;
        display: none; /* Oculto en móviles */
    }
    @media (min-width: 1100px) { .right-sidebar { display: block; } }

    .contact-item {
        display: flex;
        align-items: center;
        padding: 8px;
        border-radius: 6px;
        cursor: pointer;
    }
    .contact-item:hover { background-color: rgba(0,0,0,0.05); }
    .contact-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; position: relative; }
    .contact-status {
        width: 10px; height: 10px; background: #31a24c; border-radius: 50%;
        position: absolute; bottom: 0; right: 0; border: 2px solid white;
    }
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
            <img src="https://static.xx.fbcdn.net/rsrc.php/v3/y8/r/S0U5ECzYUSu.png" class="w-8 h-8">
            News Feed
        </a>
        <a href="{{ route('groups.index') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <img src="https://static.xx.fbcdn.net/rsrc.php/v3/y5/r/PrjLkDYpYbH.png" class="w-8 h-8">
            Grupos
        </a>
        <a href="{{ route('pages.index') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <img src="https://static.xx.fbcdn.net/rsrc.php/v3/yH/r/kyCAf2jbZvF.png" class="w-8 h-8">
            Páginas
        </a>
        <a href="{{ route('marketplace') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <img src="https://static.xx.fbcdn.net/rsrc.php/v3/yU/r/D2y-jJ2C_hO.png" class="w-8 h-8">
            Marketplace
        </a>
        <a href="{{ route('watch') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <img src="https://static.xx.fbcdn.net/rsrc.php/v3/y5/r/duk32h44Y31.png" class="w-8 h-8">
            Watch
        </a>
        <a href="{{ route('memories') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <img src="https://static.xx.fbcdn.net/rsrc.php/v3/y8/r/he-BkogPNLn.png" class="w-8 h-8">
            Recuerdos
        </a>
        <a href="{{ route('saved.index') }}" class="flex items-center gap-3 px-2 py-2 hover:bg-black/5 rounded font-semibold text-[#1c1e21]">
            <img src="https://static.xx.fbcdn.net/rsrc.php/v3/yD/r/lVijPkTeN-r.png" class="w-8 h-8">
            Guardado
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
                <div class="add-story-bottom">
                    <span class="text-xs font-bold text-gray-800">Crear historia</span>
                </div>
            </div>

            <div class="story-card">
                <div class="story-overlay"></div>
                <img src="https://ui-avatars.com/api/?name=Taylor+Otwell&background=ff2d20&color=fff" class="story-avatar">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=200" class="story-bg">
                <div class="story-name">Taylor Otwell</div>
            </div>
            
            <div class="story-card">
                <div class="story-overlay"></div>
                <img src="https://ui-avatars.com/api/?name=Elon+Musk" class="story-avatar">
                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=200" class="story-bg">
                <div class="story-name">Elon Musk</div>
            </div>

            <div class="story-card">
                <div class="story-overlay"></div>
                <img src="https://ui-avatars.com/api/?name=Miku+Hatsune&background=39c5bb&color=fff" class="story-avatar">
                <img src="https://images.unsplash.com/photo-1550439062-609e1531270e?w=200" class="story-bg">
                <div class="story-name">Miku Hatsune</div>
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
                    <span class="text-red-500 font-bold text-xl">🎥</span> 
                    <span class="text-[14px] font-semibold text-[#65676b]">Video en vivo</span>
                </div>
                <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded w-1/3 justify-center">
                    <span class="text-green-500 font-bold text-xl">📷</span> 
                    <span class="text-[14px] font-semibold text-[#65676b]">Foto/video</span>
                </div>
                <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded w-1/3 justify-center">
                    <span class="text-yellow-500 font-bold text-xl">😊</span> 
                    <span class="text-[14px] font-semibold text-[#65676b]">Sentimiento</span>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="p-3">
                <div class="flex gap-2 mb-2">
                    <div class="w-10 h-10 bg-[#4267b2] text-white flex items-center justify-center font-bold text-xl rounded-sm">l</div>
                    <div>
                        <div class="text-[#050505] font-bold text-[14px] leading-4">
                            Larabook Team <span class="text-blue-500">✓</span>
                        </div>
                        <div class="text-[#65676b] text-[12px]">Hace un momento · 🌎</div>
                    </div>
                </div>
                <div class="text-[14px] text-[#050505] mb-2">
                    ¡Bienvenido a tu nuevo News Feed, {{ Auth::user()->first_name }}! 🚀 <br>
                    Ahora tienes historias, widgets y un diseño más limpio estilo 2018.
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded p-4 text-center text-blue-800 text-sm mt-2">
                    <strong>Estado del Sistema:</strong><br>
                    Usuarios: ✅ | Páginas: ✅ | Grupos: ✅ | Feed: ✅
                </div>
            </div>
            <div class="px-3 py-2 border-t border-[#e9eaed]">
                <div class="flex justify-between items-center text-[#65676b] text-sm mb-2">
                    <span>👍 Tú y 2 personas más</span>
                    <span>0 comentarios</span>
                </div>
                <div class="border-t border-[#ced0d4] my-1"></div>
                <div class="flex gap-1 mt-1">
                    <button class="flex-1 py-1.5 hover:bg-[#f0f2f5] rounded font-semibold text-[#65676b] text-sm">👍 Me gusta</button>
                    <button class="flex-1 py-1.5 hover:bg-[#f0f2f5] rounded font-semibold text-[#65676b] text-sm">💬 Comentar</button>
                    <button class="flex-1 py-1.5 hover:bg-[#f0f2f5] rounded font-semibold text-[#65676b] text-sm">↗️ Compartir</button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="p-3">
                <div class="flex gap-2 mb-2">
                    <img src="https://ui-avatars.com/api/?name=Linus+Torvalds" class="w-10 h-10 rounded-full">
                    <div>
                        <div class="text-[#050505] font-bold text-[14px] leading-4">Linus Torvalds</div>
                        <div class="text-[#65676b] text-[12px]">Hace 2 horas · 👥</div>
                    </div>
                </div>
                <div class="text-[14px] text-[#050505]">
                    Thinking about adding AI to the kernel... just kidding. 😂🐧
                </div>
            </div>
            <div class="px-3 py-2 border-t border-[#e9eaed]">
                 <div class="flex gap-1 mt-1">
                    <button class="flex-1 py-1.5 hover:bg-[#f0f2f5] rounded font-semibold text-[#65676b] text-sm">👍 Me gusta</button>
                    <button class="flex-1 py-1.5 hover:bg-[#f0f2f5] rounded font-semibold text-[#65676b] text-sm">💬 Comentar</button>
                </div>
            </div>
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
            
            @foreach(['Mark Zuckerberg', 'Elon Musk', 'Taylor Otwell', 'Rasmus Lerdorf'] as $name)
            <div class="contact-item">
                <div class="relative mr-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}" class="contact-avatar">
                    <div class="contact-status"></div>
                </div>
                <div class="text-[#050505] font-semibold text-[13px]">{{ $name }}</div>
            </div>
            @endforeach
            
        </div>
    </div>

</div>
@endsection