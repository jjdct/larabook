@extends('layouts.app')

@section('title', 'Laravel Developers | Facebook')

@push('styles')
<style>
    /* Estilos específicos de Grupos */
    .group-cover {
        height: 350px; /* Las portadas de grupos solían ser un poco más altas */
        width: 100%;
        background-color: #1c1e21;
        position: relative;
        border-bottom: 1px solid #d3d6db;
    }
    
    .group-header-info {
        background: white;
        padding: 0 15px; /* Alineado a los lados */
        border-bottom: 1px solid #d3d6db;
    }

    .group-title {
        font-size: 28px;
        font-weight: bold;
        color: #1c1e21;
        line-height: 1.1;
    }
    
    .group-privacy {
        font-size: 13px;
        color: #606770;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 4px;
    }

    .group-nav-bar {
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 15px;
        border-top: 1px solid #e9eaed;
    }
    
    .group-nav-item {
        padding: 0 15px;
        height: 50px;
        line-height: 50px;
        color: #4b4f56;
        font-weight: bold;
        font-size: 14px;
        cursor: pointer;
        border-bottom: 2px solid transparent;
    }
    .group-nav-item:hover { background-color: #f5f6f7; }
    .group-nav-item.active { color: #4267b2; border-bottom: 2px solid #4267b2; }

    /* Input de búsqueda interno del grupo */
    .group-search-input {
        background: #f5f6f7;
        border: none;
        border-radius: 20px;
        padding: 6px 12px 6px 30px; /* Espacio para lupa */
        font-size: 13px;
        width: 200px;
        outline: none;
        transition: width 0.2s;
    }
    .group-search-input:focus { background: white; border: 1px solid #4267b2; width: 240px; }

    /* Botones de Acción */
    .btn-join {
        background-color: #e9ebee; /* Ya eres miembro */
        color: #4b4f56;
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 2px;
        font-size: 13px;
        border: 1px solid #ccd0d5;
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>
@endpush

@section('content')

    <div class="bg-white shadow-sm mb-4 -mt-4">
        <div class="max-w-[1012px] mx-auto"> <div class="group-cover overflow-hidden relative group cursor-pointer">
                <img src="https://kinsta.com/es/wp-content/uploads/sites/8/2020/02/laravel-framework.jpg" 
                     class="w-full h-full object-cover">
                
                <div class="absolute top-4 right-4 bg-white/90 hover:bg-white text-black px-3 py-1.5 rounded text-xs font-bold shadow hidden group-hover:block border border-gray-300">
                    📷 Cambiar foto del grupo
                </div>
            </div>

            <div class="max-w-[851px] mx-auto group-header-info pt-4">
                
                <div class="relative">
                    <h1 class="group-title">Laravel Developers & Linux Users 🐧</h1>
                    <div class="group-privacy">
                        <span>🔒</span> Grupo Cerrado · 15,203 miembros
                    </div>
                    
                    <div class="absolute right-0 top-1 flex gap-2">
                        <button class="btn-join">
                            <span>✓</span> Eres miembro
                        </button>
                        <button class="btn-join">
                            <span>🔔</span> Notificaciones
                        </button>
                        <button class="btn-join">
                            <span>↗️</span> Compartir
                        </button>
                        <button class="btn-join px-3">...</button>
                    </div>
                </div>

                <div class="group-nav-bar">
                    <div class="flex h-full">
                        <div class="group-nav-item active">Conversación</div>
                        <div class="group-nav-item">Miembros</div>
                        <div class="group-nav-item">Eventos</div>
                        <div class="group-nav-item">Videos</div>
                        <div class="group-nav-item">Archivos</div>
                    </div>

                    <div class="relative flex items-center mb-1">
                        <span class="absolute left-2.5 text-gray-500 text-sm">🔍</span>
                        <input type="text" placeholder="Buscar en este grupo" class="group-search-input">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="max-w-[851px] mx-auto flex gap-3 pb-20">

        <div class="w-[533px]">
            
            <div class="card p-3 mb-3">
                <div class="flex gap-2 border-b border-[#e9eaed] pb-3 mb-2">
                    <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full border border-black/10">
                    <div class="bg-gray-100 hover:bg-gray-200 rounded-full flex-grow py-2 px-3 text-[#606770] font-normal text-sm cursor-pointer border border-transparent">
                        Escribe algo...
                    </div>
                </div>
                <div class="flex justify-between px-2 pt-1">
                    <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded">
                        <span class="text-green-500 font-bold">📷</span> <span class="text-sm font-bold text-gray-600">Foto/video</span>
                    </div>
                    <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded">
                        <span class="text-blue-500 font-bold">👤</span> <span class="text-sm font-bold text-gray-600">Etiquetar</span>
                    </div>
                    <div class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 px-2 py-1 rounded">
                        <span class="text-red-500 font-bold">🎥</span> <span class="text-sm font-bold text-gray-600">Video en vivo</span>
                    </div>
                </div>
            </div>

            <div class="card border border-[#dddfe2]">
                <div class="p-3 bg-[#f5f6f7] border-b border-[#dddfe2]">
                    <span class="text-[11px] font-bold text-[#4b4f56] uppercase">📌 Publicación marcada</span>
                </div>
                <div class="p-3">
                    <div class="flex gap-2">
                        <img src="https://ui-avatars.com/api/?name=Taylor+Otwell&background=ff2d20&color=fff" class="w-10 h-10 rounded-full border border-black/10">
                        <div>
                            <div class="text-[#365899] font-bold text-sm cursor-pointer hover:underline leading-4">
                                Taylor Otwell
                            </div>
                            <div class="text-[#90949c] text-[12px] mt-0.5">
                                Admin · 2 hrs
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-[14px] text-[#1d2129] leading-snug">
                        ¡Hola a todos! Recuerden que para instalar Laravel en Debian 12 deben asegurarse de tener las extensiones de PHP 8.2 instaladas. Aquí les dejo la documentación oficial. 🚀
                    </div>
                    <div class="mt-3 border border-[#dddfe2] bg-[#f2f3f5] flex cursor-pointer hover:bg-[#ebedf0]">
                        <div class="w-[100px] h-[100px] bg-gray-300 flex-shrink-0 bg-[url('https://laravel.com/img/logomark.min.svg')] bg-center bg-no-repeat bg-[length:50px]"></div>
                        <div class="p-3 flex flex-col justify-center">
                            <div class="font-bold text-[#1d2129] text-sm leading-tight">Installation - Laravel - The PHP Framework For Web Artisans</div>
                            <div class="text-[12px] text-[#606770] mt-1 line-clamp-2">Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation...</div>
                            <div class="text-[11px] text-[#606770] mt-1 uppercase">LARAVEL.COM</div>
                        </div>
                    </div>
                </div>
                <div class="px-3 py-2 text-[12px] text-[#90949c] border-t border-[#e9eaed] flex justify-between">
                    <div class="flex items-center gap-1">👍 245</div>
                    <div>42 comentarios</div>
                </div>
            </div>

        </div>

        <div class="w-[306px] space-y-3">
            
            <div class="card p-3">
                <div class="text-[16px] font-bold text-[#1c1e21] mb-2">Acerca de este grupo</div>
                
                <div class="text-[13px] text-[#1d2129] border-b border-[#e9eaed] pb-3 mb-3">
                    Grupo oficial para desarrolladores Laravel que prefieren Linux sobre Windows. ¡Bienvenidos al lado oscuro! 🐧
                </div>

                <div class="flex gap-2 mb-2">
                    <span class="text-gray-500">🔒</span>
                    <div>
                        <div class="text-[14px] font-bold text-[#1d2129]">Cerrado</div>
                        <div class="text-[12px] text-[#606770]">Solo los miembros pueden ver quién pertenece al grupo y lo que se publica.</div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <span class="text-gray-500">🕒</span>
                    <div>
                        <div class="text-[14px] font-bold text-[#1d2129]">Historial</div>
                        <div class="text-[12px] text-[#606770]">Grupo creado el 1 de Enero de 2018</div>
                    </div>
                </div>
            </div>

            <div class="card p-3">
                <div class="flex justify-between items-center mb-2">
                    <div class="text-[14px] text-[#606770] font-bold">MIEMBROS · 15,203</div>
                    <a href="#" class="text-[12px] text-[#365899] hover:underline">Ver todo</a>
                </div>

                <div class="grid grid-cols-4 gap-1 mb-3">
                    <img src="https://ui-avatars.com/api/?name=User+One&background=random" class="w-full aspect-square rounded-[2px] cursor-pointer" title="Usuario 1">
                    <img src="https://ui-avatars.com/api/?name=User+Two&background=random" class="w-full aspect-square rounded-[2px] cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=User+Three&background=random" class="w-full aspect-square rounded-[2px] cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=User+Four&background=random" class="w-full aspect-square rounded-[2px] cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=User+Five&background=random" class="w-full aspect-square rounded-[2px] cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=User+Six&background=random" class="w-full aspect-square rounded-[2px] cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=User+Seven&background=random" class="w-full aspect-square rounded-[2px] cursor-pointer">
                    <div class="bg-[#e9ebee] flex items-center justify-center text-[#4b4f56] text-xs font-bold cursor-pointer hover:bg-[#d8dfea]">+15k</div>
                </div>

                <button class="w-full bg-[#f5f6f7] hover:bg-[#e9ebee] border border-[#ccd0d5] text-[#4b4f56] font-bold text-sm py-1 rounded-[2px]">
                    + Invitar miembros
                </button>
            </div>

            <div class="text-[12px] text-[#606770] font-bold mb-1 mt-2 flex justify-between px-1">
                GRUPOS SUGERIDOS
                <a href="#" class="text-[#365899] font-normal hover:underline">Ver todo</a>
            </div>
            <div class="card p-0 overflow-hidden">
                <div class="relative h-[80px] bg-gray-800">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/Tux.svg/1200px-Tux.svg.png" class="w-full h-full object-cover opacity-50">
                    <div class="absolute bottom-2 left-2 text-white font-bold text-shadow text-sm">Debian Lovers</div>
                </div>
                <div class="p-2 bg-white">
                    <div class="text-[12px] text-[#90949c] mb-2">230 amigos son miembros</div>
                    <button class="w-full bg-[#f5f6f7] hover:bg-[#e9ebee] border border-[#ccd0d5] text-[#4b4f56] font-bold text-xs py-1 rounded-[2px]">
                        + Unirte
                    </button>
                </div>
            </div>

        </div>

    </div>

@endsection