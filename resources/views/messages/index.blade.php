<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mensajes | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-color: #e9ebee; 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
            font-size: 11px;
            color: #141823;
        }
        .fb-dark-blue { background-color: #3b5998; }
        
        /* Estilos específicos del Inbox */
        .inbox-container {
            background-color: white;
            border: 1px solid #bdc7d8;
            border-radius: 3px;
            min-height: 500px; /* Altura mínima para que se vea bien */
            display: flex;
        }

        /* Panel Izquierdo (Lista) */
        .inbox-sidebar {
            width: 300px;
            border-right: 1px solid #d3d6db;
            background-color: #fff;
        }
        .thread-item {
            padding: 8px 10px;
            border-bottom: 1px solid #e9eaed;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .thread-item:hover { background-color: #f6f7f9; }
        .thread-item.active { background-color: #e9eaed; border-right: 3px solid #899bc1; }
        
        /* Panel Derecho (Chat) */
        .inbox-content {
            flex: 1;
            display: flex;
            flex-col;
        }
        .msg-header {
            padding: 10px 15px;
            border-bottom: 1px solid #d3d6db;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f6f7f9;
        }
        
        /* Burbujas de chat (Estilo 2012 Clásico) */
        .msg-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            padding: 5px 15px;
        }
        .msg-row:hover { background-color: #f6f7f9; } /* Hover sutil en el mensaje */
        
        .btn-reply {
            background-color: #4e69a2;
            border: 1px solid #435a8b;
            color: white;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 2px;
        }
        .btn-new-msg {
            background: linear-gradient(#f6f7f9, #ebedf0);
            border: 1px solid #ced0d4;
            color: #4b4f56;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <nav class="fb-dark-blue fixed top-0 w-full z-50 h-[42px] border-b border-[#29487d] flex items-center justify-between px-4 md:px-20 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="bg-white text-[#3b5998] w-6 h-6 rounded-[2px] flex items-center justify-center font-bold text-lg pb-1 hover:opacity-90">L</a>
            <div class="hidden md:flex bg-white rounded-[3px] border border-[#203a6d] h-6 items-center w-[350px]">
                <input type="text" placeholder="Busca personas, lugares y cosas" class="w-full px-2 text-sm bg-transparent focus:outline-none placeholder-gray-500">
            </div>
        </div>
        <div class="flex items-center gap-4 text-white font-bold text-xs">
            <a href="{{ route('users.show', auth()->user()) }}" class="flex items-center gap-2 hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-5 h-5 bg-white p-[1px]">
                <span>{{ Auth::user()->name }}</span>
            </a>
            <div class="h-4 border-r border-[#5470ad] mx-1"></div>
            <a href="{{ route('dashboard') }}" class="hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">Inicio</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:text-gray-300 ml-2 font-normal text-[10px] transform scale-x-150">▼</button>
            </form>
        </div>
    </nav>

    <div class="pt-14 max-w-[980px] mx-auto px-2 md:px-0 h-[calc(100vh-20px)] pb-4">
        
        <div class="flex justify-between items-end mb-2 px-1">
            <h1 class="text-[20px] font-bold text-[#141823]">Mensajes</h1>
            <button class="btn-new-msg text-[12px]">+ Nuevo mensaje</button>
        </div>

        <div class="inbox-container h-[500px] shadow-sm">
            
            <div class="inbox-sidebar flex flex-col">
                
                <div class="p-2 border-b border-[#e9eaed] bg-[#f6f7f9]">
                    <div class="bg-white border border-[#bdc7d8] px-2 py-1 flex items-center">
                        <input type="text" placeholder="Buscar mensajes..." class="w-full text-[11px] focus:outline-none">
                        <span class="text-gray-400">🔍</span>
                    </div>
                </div>

                <div class="overflow-y-auto flex-1">
                    <div class="thread-item active">
                        <img src="https://i.pravatar.cc/100?img=50" class="w-12 h-12 border border-gray-300">
                        <div class="flex-1 overflow-hidden">
                            <div class="flex justify-between">
                                <span class="font-bold text-[#141823] text-[13px]">Juan Dev</span>
                                <span class="text-[10px] text-gray-400">14:02</span>
                            </div>
                            <div class="text-[11px] text-gray-500 truncate">Siii, quedó idéntico al 2012...</div>
                        </div>
                    </div>

                    @for($i=1; $i<8; $i++)
                    <div class="thread-item">
                        <img src="https://i.pravatar.cc/100?img={{ $i + 15 }}" class="w-12 h-12 border border-gray-300">
                        <div class="flex-1 overflow-hidden">
                            <div class="flex justify-between">
                                <span class="font-bold text-[#333] text-[13px]">Amigo {{ $i }}</span>
                                <span class="text-[10px] text-gray-400">Ayer</span>
                            </div>
                            <div class="text-[11px] text-gray-500 truncate">
                                @if($i % 2 == 0) Hola, ¿cómo estás? @else Jajaja eso estuvo muy bueno @endif
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="p-2 text-center border-t border-[#e9eaed] text-[11px]">
                    <span class="text-[#3b5998] cursor-pointer hover:underline">Ver archivados</span>
                </div>
            </div>

            <div class="inbox-content flex flex-col">
                
                <div class="msg-header">
                    <div>
                        <h2 class="text-[14px] font-bold text-[#141823] inline-block mr-2">Juan Dev</h2>
                        <span class="text-[11px] text-gray-500">· Última conexión hace 10 min</span>
                    </div>
                    <div class="flex gap-3 text-gray-500 font-bold text-[12px]">
                        <span class="cursor-pointer hover:text-[#333]">Acciones ▼</span>
                        <span class="cursor-pointer hover:text-[#333]">🔍</span>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-4 bg-white">
                    <div class="text-center text-[10px] text-gray-400 mb-4 font-bold uppercase tracking-wide">Hoy</div>
                    
                    <div class="msg-row">
                        <img src="https://i.pravatar.cc/100?img=50" class="w-10 h-10 border border-gray-300">
                        <div>
                            <div class="text-[13px] font-bold text-[#3b5998] cursor-pointer hover:underline mb-0.5">Juan Dev</div>
                            <p class="text-[13px] text-[#141823]">Oye, ¿viste el nuevo diseño de Larabook? ¡Es impresionante!</p>
                            <span class="text-[10px] text-gray-400">13:58</span>
                        </div>
                    </div>

                    <div class="msg-row bg-[#f6f7f9] border-t border-b border-[#e9eaed] -mx-4 px-8 py-3"> 
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-10 h-10 border border-gray-300">
                        <div>
                            <div class="text-[13px] font-bold text-[#3b5998] cursor-pointer hover:underline mb-0.5">Tú</div>
                            <p class="text-[13px] text-[#141823]">Siii, quedó idéntico al 2012. ¡Es increíble! Me siento viejo jajaja.</p>
                            <span class="text-[10px] text-gray-400">14:02</span>
                        </div>
                    </div>
                    
                    <div class="msg-row">
                        <img src="https://i.pravatar.cc/100?img=50" class="w-10 h-10 border border-gray-300">
                        <div>
                            <div class="text-[13px] font-bold text-[#3b5998] cursor-pointer hover:underline mb-0.5">Juan Dev</div>
                            <p class="text-[13px] text-[#141823]">Ya ves, cuando Flash todavía existía... xD</p>
                            <span class="text-[10px] text-gray-400">14:05</span>
                        </div>
                    </div>
                </div>

                <div class="bg-[#f2f2f2] border-t border-[#bdc7d8] p-3">
                    <textarea class="w-full h-16 border border-[#bdc7d8] p-1 text-[13px] font-sans resize-none focus:border-[#3b5998] focus:outline-none mb-2" placeholder="Escribe una respuesta..."></textarea>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex gap-3 text-[11px] text-[#3b5998]">
                            <label class="flex items-center gap-1 cursor-pointer">
                                <input type="checkbox"> <span class="font-bold">Añadir archivos</span>
                            </label>
                            <label class="flex items-center gap-1 cursor-pointer">
                                <input type="checkbox"> <span class="font-bold">Añadir fotos</span>
                            </label>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-1 text-[11px] text-[#666]">
                                <input type="checkbox" checked> Intro para enviar
                            </label>
                            <button class="btn-reply">Responder</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <div class="text-center mt-4 text-[11px] text-gray-500">
            Larabook Chat © 2026
        </div>

    </div>

</body>
</html>