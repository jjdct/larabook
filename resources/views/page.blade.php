@extends('layouts.app')

@section('title', 'Larabook Team | Facebook')

@push('styles')
<style>
    /* Estilos específicos de Fan Page */
    .page-header-container { background: white; border-bottom: 1px solid #d3d6db; }
    
    .page-cover {
        height: 315px;
        width: 100%;
        background-color: #1c1e21;
        position: relative;
        overflow: hidden;
    }
    
    .page-profile-pic {
        width: 160px;
        height: 160px;
        border: 4px solid white;
        border-radius: 2px; /* Las páginas a veces usaban cuadrados redondeados */
        position: absolute;
        top: -120px;
        left: 15px;
        background: white;
        z-index: 2;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
    }

    .page-nav-bar {
        height: 45px;
        padding-left: 190px; /* Espacio para la foto */
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .page-nav-item {
        padding: 0 15px;
        height: 45px;
        line-height: 45px;
        color: #4b4f56;
        font-weight: bold;
        font-size: 14px;
        border-right: 1px solid transparent;
        cursor: pointer;
    }
    .page-nav-item:hover { background-color: #f5f6f7; }
    .page-nav-item.active { color: #4b4f56; }

    /* Botones de Call to Action */
    .cta-btn {
        padding: 6px 12px;
        font-weight: bold;
        font-size: 13px;
        border-radius: 2px;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }
    .btn-blue { background-color: #4267b2; color: white; border: 1px solid #4267b2; }
    .btn-blue:hover { background-color: #365899; }
    
    .btn-gray { background-color: #f5f6f7; color: #4b4f56; border: 1px solid #ccd0d5; }
    .btn-gray:hover { background-color: #e9ebee; }

    /* Layout de columnas */
    .page-sidebar-title { color: #4b4f56; font-size: 16px; font-weight: bold; margin-bottom: 10px; }
    .verified-badge { color: #4267b2; margin-left: 5px; font-size: 18px; }
</style>
@endpush

@section('content')

    <div class="page-header-container shadow-sm mb-4 -mt-4 bg-white">
    <div class="max-w-[851px] mx-auto relative h-[360px]"> <div class="h-[315px] w-full bg-gray-800 relative overflow-hidden group cursor-pointer">
            <img src="https://images.unsplash.com/photo-1555099962-4199c345e5dd?q=80&w=1000&auto=format&fit=crop" 
                 class="w-full h-full object-cover">
            
            <div class="absolute bottom-4 left-[200px]"> <h1 class="text-white text-[30px] font-bold text-shadow drop-shadow-md flex items-center">
                    Larabook Team 
                    @if(true) <span class="text-[#1877f2] bg-white rounded-full w-5 h-5 flex items-center justify-center text-[12px] ml-2" title="Verificado">✓</span>
                    @endif
                </h1>
                <div class="text-white text-sm opacity-90 font-normal">@larabook_official</div>
            </div>
        </div>

        <div class="absolute top-[230px] left-[15px] z-10">
            <div class="w-[160px] h-[160px] bg-white p-1 rounded-full border border-gray-300"> <div class="w-full h-full bg-[#f0f2f5] rounded-full flex items-center justify-center overflow-hidden">
                     <div class="text-[#4267b2] text-[80px] font-bold select-none pb-2">l</div>
                </div>
            </div>
        </div>

        <div class="h-[45px] pl-[190px] flex items-center justify-between border-b border-[#d3d6db] bg-white">
            <div class="flex h-full">
                <div class="px-4 h-full flex items-center font-bold text-[#4b4f56] border-b-2 border-[#4267b2] cursor-pointer">Inicio</div>
                <div class="px-4 h-full flex items-center font-bold text-[#4b4f56] text-sm cursor-pointer hover:bg-gray-50">Publicaciones</div>
                <div class="px-4 h-full flex items-center font-bold text-[#4b4f56] text-sm cursor-pointer hover:bg-gray-50">Fotos</div>
            </div>

            <div class="flex gap-2 pr-4">
                <button class="bg-[#f5f6f7] hover:bg-[#e9ebee] border border-[#ccd0d5] text-[#4b4f56] font-bold text-sm px-3 py-1 rounded-[2px] flex items-center gap-2">
                    👍 Te gusta
                </button>
                <button class="bg-[#4267b2] hover:bg-[#365899] border border-[#4267b2] text-white font-bold text-sm px-3 py-1 rounded-[2px] flex items-center gap-2">
                    💬 Enviar mensaje
                </button>
            </div>
        </div>

    </div>
</div>

    <div class="max-w-[851px] mx-auto flex gap-3 pb-20">

        <div class="w-[306px] space-y-3">
            
            <div class="card p-3">
                <div class="page-sidebar-title border-b border-[#e9eaed] pb-2">Información</div>
                
                <div class="py-2 text-[13px] text-[#1d2129]">
                    <div class="flex gap-3 mb-2">
                        <span class="text-gray-400">📍</span>
                        <span>Menlo Park, California (Virtual)</span>
                    </div>
                    <div class="flex gap-3 mb-2">
                        <span class="text-gray-400">ℹ️</span>
                        <span>Empresa de software · Sitio web de computadoras e internet</span>
                    </div>
                    <div class="flex gap-3 mb-2">
                        <span class="text-gray-400">🌐</span>
                        <a href="#" class="text-[#365899] hover:underline">larabook.test</a>
                    </div>
                    <button class="w-full mt-2 bg-[#f5f6f7] hover:bg-[#e9ebee] text-[#4b4f56] font-bold py-1 rounded-sm border border-[#ccd0d5] text-xs">
                        Sugerir cambios
                    </button>
                </div>
            </div>

            <div class="card p-3">
                <div class="page-sidebar-title border-b border-[#e9eaed] pb-2">Comunidad</div>
                <div class="mt-2 text-[#365899] text-[12px] font-bold hover:underline cursor-pointer">
                    A 2,394 personas les gusta esto
                </div>
                <div class="mt-1 text-[#365899] text-[12px] font-bold hover:underline cursor-pointer">
                    2,401 personas siguen esto
                </div>
                
                <div class="flex -space-x-2 mt-3">
                    <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=Mark+Zuckerberg" alt="">
                    <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=Miku+Peluche" alt="">
                    <img class="w-8 h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=Elon+Musk" alt="">
                    <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-[10px] text-gray-500 font-bold">+2k</div>
                </div>
            </div>

            <div class="card p-3">
                <div class="page-sidebar-title">Fotos</div>
                <div class="grid grid-cols-3 gap-1 rounded overflow-hidden">
                    <div class="bg-gray-200 h-[90px]"></div>
                    <div class="bg-gray-300 h-[90px]"></div>
                    <div class="bg-gray-400 h-[90px]"></div>
                </div>
            </div>

        </div>

        <div class="w-[533px]">
            
            <div class="card p-3 mb-3 bg-white">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-bold text-[#4b4f56] text-sm">Escribe algo en la página...</span>
                </div>
                <div class="flex gap-2">
                    <img src="{{ Auth::user()->avatar }}" class="w-8 h-8 rounded-full">
                    <input type="text" placeholder="Comparte tu opinión..." class="flex-grow border border-[#bdc7d8] px-2 py-1 text-sm rounded-sm">
                </div>
            </div>

            <div class="card">
                <div class="p-3">
                    <div class="flex gap-2">
                        <div class="w-10 h-10 bg-[#4267b2] text-white flex items-center justify-center font-bold text-xl rounded-sm">l</div>
                        
                        <div>
                            <div class="text-[#365899] font-bold text-sm cursor-pointer hover:underline leading-4 flex items-center gap-1">
                                Larabook Team <span class="text-[#365899] text-[10px]">✓</span>
                            </div>
                            <div class="text-[#90949c] text-[12px] mt-0.5">
                                <span class="text-[#4b4f56] font-bold text-[10px] uppercase">Publicación fijada</span> · 1 de febrero · 🌎
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-2 text-[14px] text-[#1d2129]">
                        ¡Bienvenidos a la página oficial del proyecto Larabook! 🚀<br>
                        Estamos reconstruyendo la historia de las redes sociales, línea por línea.
                    </div>
                </div>
                
                <div class="h-[300px] bg-gray-800 flex items-center justify-center text-white font-mono">
                    > php artisan serve... 
                </div>
                
                <div class="px-3 py-2 text-[12px] text-[#90949c] border-b border-[#e9eaed] flex justify-between">
                    <div class="flex items-center gap-1">👍 ❤️ 1,203</div>
                    <div>54 comentarios · 12 veces compartido</div>
                </div>

                <div class="flex text-[#606770] font-bold text-[13px] py-1">
                    <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded">👍 Me gusta</div>
                    <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded">💬 Comentar</div>
                    <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded">🔄 Compartir</div>
                </div>
            </div>

        </div>

    </div>

@endsection