@extends('layouts.app')

@section('title', 'Mark Zuckerberg')

@push('styles')
<style>
    /* Estilos específicos del Perfil */
    .cover-gradient {
        background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 20%);
    }
    .profile-nav-item {
        color: #4b4f56;
        font-weight: bold;
        font-size: 14px;
        padding: 0 15px;
        height: 43px;
        line-height: 43px;
        border-right: 1px solid #e9eaed;
        cursor: pointer;
    }
    .profile-nav-item:hover { background-color: #f5f6f7; }
    .profile-nav-item.active { color: #4b4f56; }
    
    .action-btn {
        background-color: #f5f6f7;
        border: 1px solid #ccd0d5;
        color: #4b4f56;
        font-weight: bold;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 2px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .action-btn:hover { background-color: #e9ebee; }
</style>
@endpush

@section('content')
    <div class="-mt-3"> 
        
        <div class="bg-white border-b border-[#d3d6db] shadow-sm">
            <div class="max-w-[851px] mx-auto relative">
                
                <div class="relative w-full h-[315px] bg-gray-300 overflow-hidden group cursor-pointer">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Mark_Zuckerberg_F8_2019_Keynote_%2832830578717%29_%28cropped%29.jpg/800px-Mark_Zuckerberg_F8_2019_Keynote_%2832830578717%29_%28cropped%29.jpg" 
                         class="w-full h-full object-cover object-[50%_20%]">
                    
                    <div class="absolute bottom-0 left-0 w-full h-[100px] cover-gradient"></div>

                    <h1 class="absolute bottom-[20px] left-[180px] text-white text-[30px] font-bold text-shadow drop-shadow-md">
                        Mark Zuckerberg
                    </h1>

                    <div class="absolute top-4 left-4 bg-black/50 hover:bg-black/70 text-white p-2 rounded cursor-pointer hidden group-hover:block text-sm font-bold">
                        📷 Actualizar foto de portada
                    </div>
                </div>

                <div class="h-[43px] bg-white flex items-center justify-between pl-[180px]">
                    <div class="flex h-full">
                        <div class="profile-nav-item border-l border-[#e9eaed] text-[#4b4f56]">Biografía</div>
                        <div class="profile-nav-item text-[#385898]">Información</div>
                        <div class="profile-nav-item text-[#385898]">Amigos <span class="text-[#898f9c] font-normal pl-1">4,934</span></div>
                        <div class="profile-nav-item text-[#385898]">Fotos</div>
                        <div class="profile-nav-item text-[#385898]">Archivo</div>
                        <div class="profile-nav-item text-[#385898] border-none flex items-center">Más ▼</div>
                    </div>

                    <div class="flex gap-2 pr-4 items-center">
                        <button class="action-btn">👋 <span class="hidden sm:inline">Saludar</span></button>
                        <button class="action-btn">💬 <span class="hidden sm:inline">Mensaje</span></button>
                        <button class="action-btn">... </button>
                    </div>
                </div>

                <div class="absolute top-[160px] left-[15px] p-1 bg-white rounded-full border border-[rgba(0,0,0,.1)] z-10">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/18/Mark_Zuckerberg_F8_2019_Keynote_%2832830578717%29_%28cropped%29.jpg" 
                         class="w-[160px] h-[160px] rounded-full object-cover border border-[rgba(0,0,0,.1)]">
                </div>

            </div>
        </div>

        <div class="max-w-[851px] mx-auto mt-4 flex gap-3 pb-20">
            
            <div class="w-[306px] space-y-3">
                
                <div class="card p-3">
                    <div class="flex items-center gap-2 mb-3 text-[#1d2129] font-bold text-sm">
                        🌎 Intro
                    </div>
                    
                    <div class="text-center text-sm mb-4">
                        "Bringing the world closer together."
                    </div>

                    <div class="border-t border-[#e5e5e5] my-3"></div>

                    <ul class="space-y-3 text-[12px] text-[#1d2129]">
                        <li class="flex gap-2 items-center"><span class="opacity-60">💼</span> Director ejecutivo en <strong>Facebook</strong></li>
                        <li class="flex gap-2 items-center"><span class="opacity-60">🎓</span> Estudió Informática en <strong>Harvard University</strong></li>
                        <li class="flex gap-2 items-center"><span class="opacity-60">🏠</span> Vive en <strong>Palo Alto, California</strong></li>
                        <li class="flex gap-2 items-center"><span class="opacity-60">📍</span> De <strong>Dobbs Ferry, New York</strong></li>
                        <li class="flex gap-2 items-center"><span class="opacity-60">📡</span> Tiene <strong>118,230,201 seguidores</strong></li>
                    </ul>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Mark_Zuckerberg_F8_2019_Keynote_%2832830578717%29_%28cropped%29.jpg/100px-Mark_Zuckerberg_F8_2019_Keynote_%2832830578717%29_%28cropped%29.jpg" class="w-full h-[150px] object-cover rounded bg-gray-200">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR61yTaa8q3zC9C0M8aK-WqK1b4yC_X_yX8Xg&s" class="w-[32%] h-[80px] object-cover rounded bg-gray-200">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR61yTaa8q3zC9C0M8aK-WqK1b4yC_X_yX8Xg&s" class="w-[32%] h-[80px] object-cover rounded bg-gray-200">
                    </div>
                </div>

                <div class="card p-3">
                    <div class="flex justify-between items-end mb-3">
                        <div class="text-[#1d2129] font-bold text-sm">Amigos</div>
                        <a href="#" class="text-[#365899] text-[12px] hover:underline">Ver todos</a>
                    </div>
                    <div class="text-[#90949c] text-[12px] mb-3 -mt-2">4,934 amigos</div>
                    
                    <div class="grid grid-cols-3 gap-1">
                        <div>
                            <div class="w-full h-[90px] bg-gray-200 bg-[url('https://ui-avatars.com/api/?name=Priscilla+Chan&background=random')] bg-cover"></div>
                            <div class="text-[12px] font-bold text-[#365899] leading-tight mt-1 hover:underline cursor-pointer">Priscilla Chan</div>
                        </div>
                        <div>
                            <div class="w-full h-[90px] bg-gray-200 bg-[url('https://ui-avatars.com/api/?name=Sheryl+Sandberg&background=random')] bg-cover"></div>
                            <div class="text-[12px] font-bold text-[#365899] leading-tight mt-1 hover:underline cursor-pointer">Sheryl Sandberg</div>
                        </div>
                        <div>
                            <div class="w-full h-[90px] bg-gray-200 bg-[url('https://ui-avatars.com/api/?name=Bill+Gates&background=random')] bg-cover"></div>
                            <div class="text-[12px] font-bold text-[#365899] leading-tight mt-1 hover:underline cursor-pointer">Bill Gates</div>
                        </div>
                        <div>
                            <div class="w-full h-[90px] bg-gray-200 bg-[url('https://ui-avatars.com/api/?name=Elon+Musk&background=random')] bg-cover"></div>
                            <div class="text-[12px] font-bold text-[#365899] leading-tight mt-1 hover:underline cursor-pointer">Elon Musk</div>
                        </div>
                        <div>
                            <div class="w-full h-[90px] bg-gray-200 bg-[url('https://ui-avatars.com/api/?name=Eduardo+Saverin&background=random')] bg-cover"></div>
                            <div class="text-[12px] font-bold text-[#365899] leading-tight mt-1 hover:underline cursor-pointer">Eduardo Saverin</div>
                        </div>
                        <div>
                            <div class="w-full h-[90px] bg-gray-200 bg-[url('https://ui-avatars.com/api/?name=Sean+Parker&background=random')] bg-cover"></div>
                            <div class="text-[12px] font-bold text-[#365899] leading-tight mt-1 hover:underline cursor-pointer">Sean Parker</div>
                        </div>
                    </div>
                </div>

                <div class="text-[11px] text-[#90949c]">
                    Privacidad · Condiciones · Publicidad · Opciones de anuncios · Cookies · Más · Larabook © 2026
                </div>
            </div>

            <div class="w-[533px]">
                
                <div class="card p-3">
                    <div class="flex gap-2 border-b border-[#e9eaed] pb-3 text-[12px] font-bold text-[#4b4f56]">
                        <div class="flex items-center gap-1 px-2 py-1 bg-[#f5f6f7] rounded hover:bg-[#ebedf0] cursor-pointer">✏️ Crear publicación</div>
                        <div class="flex items-center gap-1 px-2 py-1 hover:bg-[#f5f6f7] rounded cursor-pointer border-l border-transparent">📷 Foto/video</div>
                        <div class="flex items-center gap-1 px-2 py-1 hover:bg-[#f5f6f7] rounded cursor-pointer">🎥 Video en vivo</div>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full border border-black/10">
                        <div class="flex-grow py-2 text-[#90949c] font-normal text-sm cursor-text">
                            Escribe algo a Mark...
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="p-3">
                        <div class="flex gap-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/1/18/Mark_Zuckerberg_F8_2019_Keynote_%2832830578717%29_%28cropped%29.jpg" class="w-10 h-10 rounded-full border border-black/10">
                            <div>
                                <div class="text-[#365899] font-bold text-sm cursor-pointer hover:underline leading-4">Mark Zuckerberg</div>
                                <div class="text-[#90949c] text-[12px] mt-0.5">14 de enero · Palo Alto, CA · 🌎</div>
                            </div>
                        </div>
                        <div class="mt-2 text-[14px] text-[#1d2129]">
                            Building new ways to connect. The future is private.
                        </div>
                    </div>
                    <img src="https://s.france24.com/media/display/e6279b3c-db08-11eb-9889-005056a90284/w:1280/p:16x9/2021-07-02T160249Z_502384799_RC2QEO9W4921_RTRMADP_3_USA-FACEBOOK.jpg" class="w-full border-y border-[#e9eaed]">
                    
                    <div class="px-3 py-2 text-[12px] text-[#90949c] border-b border-[#e9eaed] flex justify-between">
                        <div class="flex items-center gap-1">👍 😮 ❤️ 245,392</div>
                        <div>23,940 comentarios · 4,203 veces compartido</div>
                    </div>

                    <div class="flex text-[#606770] font-bold text-[13px] py-1">
                        <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded">👍 Me gusta</div>
                        <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded">💬 Comentar</div>
                        <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded">🔄 Compartir</div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection