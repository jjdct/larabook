@extends('layouts.app')

@section('title', 'Messenger | Larabook')

@push('styles')
    <style>
        /* Ajustes específicos para Messenger para que ocupe el alto de la pantalla */
        body { overflow-y: hidden; } /* Evita doble scroll */
        .messenger-container { 
            height: calc(100vh - 60px); /* Restamos la altura del navbar */
            background: white; 
            border-left: 1px solid #dddfe2; 
            border-right: 1px solid #dddfe2;
            display: flex;
        }
        
        /* Scrollbars personalizados estilo FB */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
        .custom-scroll:hover::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); }

        /* Burbujas de chat */
        .bubble-received { background-color: #f0f0f0; color: #1c1e21; border-radius: 18px; padding: 8px 12px; max-width: 70%; font-size: 14px; align-self: flex-start; }
        .bubble-sent { background-color: #0084ff; color: white; border-radius: 18px; padding: 8px 12px; max-width: 70%; font-size: 14px; align-self: flex-end; }
        
        /* Contacto activo */
        .contact-item:hover { background-color: #f5f6f7; }
        .contact-item.active { background-color: rgba(0, 132, 255, .1); }
        .contact-item.active .contact-name { color: #1c1e21; font-weight: bold; }
    </style>
@endpush

@section('content')
    <div class="messenger-container shadow-sm">
        
        <div class="w-[320px] border-r border-[#dddfe2] flex flex-col">
            
            <div class="h-[60px] flex items-center justify-between px-4 border-b border-[#dddfe2]">
                <h1 class="text-[24px] font-bold text-[#1c1e21]">Messenger</h1>
                <div class="flex gap-2">
                    <button class="w-8 h-8 rounded-full hover:bg-[#f5f6f7] flex items-center justify-center text-[#0084ff] text-xl">⚙️</button>
                    <button class="w-8 h-8 rounded-full hover:bg-[#f5f6f7] flex items-center justify-center text-[#0084ff] text-xl">📝</button>
                </div>
            </div>

            <div class="p-3">
                <input type="text" placeholder="Buscar en Messenger" class="w-full bg-[#f5f6f7] border-none rounded-full px-4 py-2 text-sm text-[#1c1e21] placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-300">
            </div>

            <div class="flex-grow overflow-y-auto custom-scroll">
                
                <div class="contact-item active cursor-pointer p-3 flex items-center gap-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Mark+Zuckerberg&background=random" class="w-12 h-12 rounded-full border border-gray-200">
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <div class="contact-name text-[15px] truncate text-[#1c1e21]">Mark Zuckerberg</div>
                        <div class="flex items-center gap-1 text-[13px] text-[#65676b]">
                            <span class="truncate">¿Te gusta el diseño clásico?</span>
                            <span>·</span>
                            <span>10:30 AM</span>
                        </div>
                    </div>
                    <img src="{{ Auth::user()->avatar }}" class="w-3 h-3 rounded-full">
                </div>

                <div class="contact-item cursor-pointer p-3 flex items-center gap-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Tom+Myspace&background=000&color=fff" class="w-12 h-12 rounded-full border border-gray-200">
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <div class="text-[15px] font-normal text-[#1c1e21]">Tom Anderson</div>
                        <div class="flex items-center gap-1 text-[13px] text-[#65676b] font-bold">
                            <span class="truncate">¡Te extraño en el top 8!</span>
                            <span>·</span>
                            <span>Ayer</span>
                        </div>
                    </div>
                    <div class="w-3 h-3 bg-[#0084ff] rounded-full"></div>
                </div>

                <div class="contact-item cursor-pointer p-3 flex items-center gap-3">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full bg-[#0084ff] flex items-center justify-center text-white font-bold text-xl border border-gray-200">l</div>
                    </div>
                    <div class="flex-grow overflow-hidden">
                        <div class="text-[15px] font-normal text-[#1c1e21]">Larabook Team</div>
                        <div class="flex items-center gap-1 text-[13px] text-[#65676b]">
                            <span class="truncate">Bienvenido a la plataforma.</span>
                            <span>·</span>
                            <span>Lun</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex-grow flex flex-col bg-white">
            
            <div class="h-[60px] flex items-center justify-between px-4 border-b border-[#dddfe2] shadow-sm z-10">
                <div class="flex items-center gap-3">
                    <div class="relative">
                         <img src="https://ui-avatars.com/api/?name=Mark+Zuckerberg&background=random" class="w-10 h-10 rounded-full border border-gray-200">
                         <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div>
                        <div class="text-[16px] font-bold text-[#1c1e21] leading-tight">Mark Zuckerberg</div>
                        <div class="text-[12px] text-[#65676b]">Activo ahora</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-[#0084ff] text-xl">
                    <button class="hover:bg-[#f5f6f7] w-9 h-9 rounded-full flex items-center justify-center">📞</button>
                    <button class="hover:bg-[#f5f6f7] w-9 h-9 rounded-full flex items-center justify-center">📹</button>
                    <button class="hover:bg-[#f5f6f7] w-9 h-9 rounded-full flex items-center justify-center">ℹ️</button>
                </div>
            </div>

            <div class="flex-grow p-4 overflow-y-auto custom-scroll flex flex-col gap-2">
                
                <div class="text-center text-[11px] text-[#65676b] my-4 uppercase font-bold tracking-wide">Hoy, 10:23 AM</div>

                <div class="flex items-end gap-2 group">
                    <img src="https://ui-avatars.com/api/?name=Mark+Zuckerberg&background=random" class="w-7 h-7 rounded-full mb-1">
                    <div class="bubble-received" title="10:23 AM">
                        Hola {{ Auth::user()->first_name }}, vi que estás recreando Larabook.
                    </div>
                </div>

                <div class="flex items-end gap-2 group">
                    <img src="https://ui-avatars.com/api/?name=Mark+Zuckerberg&background=random" class="w-7 h-7 rounded-full mb-1 opacity-0"> <div class="bubble-received" title="10:24 AM">
                        ¿Estás usando Tailwind? Se ve bastante limpio.
                    </div>
                </div>

                <div class="flex items-end gap-2 self-end group">
                    <div class="bubble-sent bg-[#0084ff]" title="10:25 AM">
                        ¡Sí! Estamos usando Laravel y Tailwind para traer de vuelta el estilo de 2018.
                    </div>
                </div>

                <div class="flex items-end gap-2 self-end group">
                    <div class="bubble-sent bg-[#0084ff]" title="10:26 AM">
                        Mejor que el Metaverso, ¿no crees? 😉
                    </div>
                    <img src="https://ui-avatars.com/api/?name=visto" class="w-3 h-3 rounded-full mb-1 bg-gray-200" title="Visto">
                </div>

                <div class="flex items-end gap-2 group mt-2">
                    <img src="https://ui-avatars.com/api/?name=Mark+Zuckerberg&background=random" class="w-7 h-7 rounded-full mb-1">
                    <div class="bubble-received" title="10:30 AM">
                        ¿Te gusta el diseño clásico? Es mucho más rápido que React a veces...
                    </div>
                </div>

                <div class="flex items-end gap-2 mt-1">
                    <img src="https://ui-avatars.com/api/?name=Mark+Zuckerberg&background=random" class="w-7 h-7 rounded-full mb-1">
                    <div class="bg-[#f0f0f0] rounded-[18px] px-3 py-2 w-12 flex items-center justify-center gap-1">
                        <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>

            </div>

            <div class="p-3 border-t border-[#dddfe2] flex items-center gap-2">
                <div class="flex items-center text-[#0084ff] text-xl gap-2 px-1">
                    <button class="hover:bg-[#f5f6f7] p-2 rounded-full">📷</button>
                    <button class="hover:bg-[#f5f6f7] p-2 rounded-full">🖼️</button>
                    <button class="hover:bg-[#f5f6f7] p-2 rounded-full">🎤</button>
                </div>
                
                <div class="flex-grow relative">
                    <input type="text" placeholder="Escribe un mensaje..." class="w-full bg-[#f0f2f5] rounded-full pl-4 pr-10 py-2 text-[15px] focus:outline-none">
                    <button class="absolute right-2 top-1.5 text-xl hover:opacity-80">😀</button>
                </div>

                <button class="text-[#0084ff] text-2xl hover:bg-[#f5f6f7] p-2 rounded-full transform hover:scale-110 transition-transform">
                    👍
                </button>
            </div>

        </div>

    </div>
@endsection