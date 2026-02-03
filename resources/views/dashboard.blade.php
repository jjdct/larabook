@extends('layouts.app')

@section('title', 'Larabook')

@push('styles')
    <style>
        /* Estilos exclusivos del Dashboard */
        .sidebar-link { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            padding: 8px 6px; 
            border-radius: 2px; 
            color: #1d2129; 
            font-size: 13px; 
            text-decoration: none; 
            margin-bottom: 2px; 
            font-weight: normal;
        }
        .sidebar-link:hover { background-color: #dfe3ee; }
        .sidebar-icon { font-size: 20px; width: 24px; text-align: center; }
    </style>
@endpush

@section('content')
    <div class="flex gap-4 justify-center">
        
        <aside class="w-[180px] hidden md:block sticky top-[60px] h-fit">
            
            <a href="#" class="sidebar-link font-semibold">
                <img src="{{ Auth::user()->avatar }}" class="w-6 h-6 rounded-full border border-black/10 bg-white">
                <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            </a>

            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <span class="sidebar-icon text-blue-500">📰</span> 
                <span>News Feed</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon text-blue-500">💬</span> 
                <span>Messenger</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon text-green-500">📺</span> 
                <span>Watch</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon text-blue-400">🏪</span> 
                <span>Marketplace</span>
            </a>

            <div class="mt-4 text-[#616770] font-bold text-[13px] uppercase tracking-wide mb-1 px-2">Explorar</div>
            
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon text-blue-600">👥</span> 
                <span>Grupos</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon text-orange-500">🚩</span> 
                <span>Páginas</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon text-red-500">📅</span> 
                <span>Eventos</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon text-purple-500">🟣</span> 
                <span>Recuerdos</span>
            </a>
            <a href="#" class="sidebar-link">
                <span class="sidebar-icon text-blue-400">💾</span> 
                <span>Guardado</span>
            </a>
        </aside>

        <section class="w-[500px]">
            
            <div class="card p-3">
                <div class="flex gap-2 border-b border-[#e5e5e5] pb-3 mb-2">
                    <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full border border-black/10 bg-white">
                    <div class="bg-[#f0f2f5] rounded-full flex-grow py-2 px-4 text-[#65676b] font-normal text-sm cursor-pointer hover:bg-[#e4e6eb] transition-colors">
                        ¿Qué estás pensando, {{ Auth::user()->first_name }}?
                    </div>
                </div>
                <div class="flex justify-between pt-1 px-2">
                    <button class="flex items-center gap-2 px-2 py-1.5 hover:bg-[#f2f2f2] rounded-md text-sm font-semibold text-[#606770]">
                        <span class="text-green-500 text-lg">📷</span> Foto/video
                    </button>
                    <button class="flex items-center gap-2 px-2 py-1.5 hover:bg-[#f2f2f2] rounded-md text-sm font-semibold text-[#606770]">
                        <span class="text-blue-500 text-lg">👤</span> Etiquetar
                    </button>
                    <button class="flex items-center gap-2 px-2 py-1.5 hover:bg-[#f2f2f2] rounded-md text-sm font-semibold text-[#606770]">
                        <span class="text-yellow-500 text-lg">😊</span> Sentimiento
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="p-3 flex items-center gap-2">
                    <div class="w-10 h-10 bg-[#4267b2] rounded-full flex items-center justify-center text-white font-bold text-2xl border border-black/10 select-none">
                        l
                    </div>
                    <div>
                        <div class="text-[#385898] font-bold text-sm hover:underline cursor-pointer">Larabook Team</div>
                        <div class="text-[#616770] text-[12px] flex items-center gap-1">
                            Hace un momento · <span title="Público">🌎</span>
                        </div>
                    </div>
                    <div class="ml-auto text-gray-500 cursor-pointer text-xl hover:bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center">···</div>
                </div>
                
                <div class="px-3 pb-2 text-[14px] text-[#1d2129] leading-5">
                    <p class="mb-2">¡Bienvenido a <strong>Larabook</strong>, {{ Auth::user()->first_name }}! 🎉</p>
                    <p>Ahora con la "l" de legalidad y layouts optimizados. Este es el comienzo de tu nueva red social clásica.</p>
                </div>
                
                <div class="border-t border-b border-[#dddfe2] bg-[#f0f2f5] min-h-[250px] flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/world.png') }}" class="object-cover w-full opacity-90 block">
                </div>
                
                <div class="px-3 py-2 text-xs text-[#65676b] flex justify-between border-b border-[#dddfe2]">
                    <div class="flex items-center gap-1">
                        <span class="bg-blue-500 rounded-full w-4 h-4 flex items-center justify-center text-white text-[9px]">👍</span>
                        1 persona
                    </div>
                    <div>
                        0 comentarios
                    </div>
                </div>

                <div class="p-1 mx-3 flex gap-1 mt-1 mb-1">
                     <button class="flex-1 py-1.5 text-[#606770] font-bold text-[13px] hover:bg-[#f2f2f2] rounded flex items-center justify-center gap-1.5 transition-colors">
                         <span class="text-lg opacity-60">👍</span> Me gusta
                     </button>
                     <button class="flex-1 py-1.5 text-[#606770] font-bold text-[13px] hover:bg-[#f2f2f2] rounded flex items-center justify-center gap-1.5 transition-colors">
                         <span class="text-lg opacity-60">💬</span> Comentar
                     </button>
                     <button class="flex-1 py-1.5 text-[#606770] font-bold text-[13px] hover:bg-[#f2f2f2] rounded flex items-center justify-center gap-1.5 transition-colors">
                         <span class="text-lg opacity-60">↗️</span> Compartir
                     </button>
                </div>
            </div>

        </section>

        <aside class="w-[300px] hidden lg:block sticky top-[60px] h-fit space-y-4">
            
            <div class="card p-3">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-[#616770] font-bold text-[13px]">Historias</span>
                    <a href="#" class="text-[#385898] text-xs hover:underline">Ver todas</a>
                </div>
                <div class="text-center py-6 text-sm text-[#90949c] border border-dashed border-gray-300 rounded">
                    No hay historias recientes.
                </div>
            </div>

            <div class="card p-3">
                 <div class="flex justify-between items-center mb-3">
                    <span class="text-[#616770] font-bold text-[13px]">Personas que quizá conozcas</span>
                    <a href="#" class="text-[#385898] text-xs hover:underline">Ver todo</a>
                </div>
                
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gray-200 rounded-full border border-gray-300"></div>
                    <div class="flex-grow">
                         <div class="font-bold text-[#385898] text-[13px] hover:underline cursor-pointer">Mark Z.</div>
                         <div class="text-[#90949c] text-xs">Amigo de Tom</div>
                    </div>
                    <button class="text-[#4b4f56] hover:bg-[#dfe3ee] px-2 py-1 rounded text-xs font-bold border border-[#dddfe2] flex items-center gap-1">
                        👤+
                    </button>
                </div>
            </div>
            
            <div class="text-[11px] text-[#616770] px-1 space-x-1 leading-4">
                <a href="#" class="hover:underline">Privacidad</a> · 
                <a href="#" class="hover:underline">Condiciones</a> · 
                <a href="#" class="hover:underline">Publicidad</a> · 
                <a href="#" class="hover:underline">Cookies</a> · 
                <a href="#" class="hover:underline">Más</a>
                <div class="mt-1">Larabook © {{ date('Y') }}</div>
            </div>
        </aside>

    </div>
@endsection