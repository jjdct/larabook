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
        
        /* Contenedor principal que ocupa la altura restante */
        .inbox-container {
            background-color: white;
            border: 1px solid #bdc7d8;
            border-radius: 3px;
            display: flex;
            height: calc(100vh - 100px); /* Ajuste para que ocupe la pantalla menos el header */
            overflow: hidden;
        }

        /* Panel Izquierdo (Lista) */
        .inbox-sidebar {
            width: 300px;
            border-right: 1px solid #d3d6db;
            background-color: #fff;
            display: flex;
            flex-direction: column;
        }
        .thread-item {
            padding: 8px 10px;
            border-bottom: 1px solid #e9eaed;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: background-color 0.1s;
        }
        .thread-item:hover { background-color: #f6f7f9; }
        
        /* Usuario activo */
        .thread-item.active { 
            background-color: #e9eaed; 
            border-right: 3px solid #899bc1; 
        }
        
        /* Panel Derecho (Chat) */
        .inbox-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: white;
        }
        .msg-header {
            padding: 10px 15px;
            border-bottom: 1px solid #d3d6db;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f6f7f9;
            height: 50px;
        }
        
        /* Burbujas de chat */
        .msg-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            padding: 5px 15px;
        }
        .msg-row:hover { background-color: #f6f7f9; }
        
        /* Mensajes PROPIOS (Fondo grisáceo sutil) */
        .msg-own {
            background-color: #f6f7f9;
            border-top: 1px solid #e9eaed;
            border-bottom: 1px solid #e9eaed;
        }

        .btn-reply {
            background-color: #4e69a2;
            border: 1px solid #435a8b;
            color: white;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 2px;
            cursor: pointer;
        }
        .btn-new-msg {
            background: linear-gradient(#f6f7f9, #ebedf0);
            border: 1px solid #ced0d4;
            color: #4b4f56;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 2px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <nav class="fb-dark-blue fixed top-0 w-full z-50 h-[42px] border-b border-[#29487d] flex items-center justify-between px-4 md:px-20 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="bg-white text-[#3b5998] w-6 h-6 rounded-[2px] flex items-center justify-center font-bold text-lg pb-1 hover:opacity-90">L</a>
            <form action="{{ route('search') }}" method="GET" class="hidden md:flex bg-white rounded-[3px] border border-[#203a6d] h-6 items-center w-[350px]">
                <input type="text" name="q" placeholder="Busca personas, lugares y cosas" class="w-full px-2 text-sm bg-transparent focus:outline-none placeholder-gray-500">
                <button type="submit" class="bg-[#f2f2f2] h-full px-2 flex items-center border-l border-gray-300 cursor-pointer">🔍</button>
            </form>
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

    <div class="pt-14 max-w-[980px] mx-auto px-2 md:px-0 h-screen pb-4 flex flex-col">
        
        <div class="flex justify-between items-end mb-2 px-1 shrink-0">
            <h1 class="text-[20px] font-bold text-[#141823]">
                @if(isset($isArchivedView) && $isArchivedView)
                    Mensajes Archivados
                @else
                    Mensajes
                @endif
            </h1>
            <a href="#" class="btn-new-msg text-[12px]">+ Nuevo mensaje</a>
        </div>

        <div class="inbox-container shadow-sm">
            
            <div class="inbox-sidebar">
                
                <div class="p-2 border-b border-[#e9eaed] bg-[#f6f7f9] shrink-0">
                    <div class="bg-white border border-[#bdc7d8] px-2 py-1 flex items-center">
                        <input type="text" placeholder="Buscar mensajes..." class="w-full text-[11px] focus:outline-none">
                        <span class="text-gray-400">🔍</span>
                    </div>
                </div>

                <div class="overflow-y-auto flex-1">
                    @forelse($conversations as $conv)
                        @php
                            $isActive = isset($user) && $user->id === $conv['user']->id;
                        @endphp

                        <a href="{{ route('messages.show', $conv['user']) }}" class="thread-item {{ $isActive ? 'active' : '' }}">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($conv['user']->name) }}&background=random" class="w-12 h-12 border border-gray-300">
                            <div class="flex-1 overflow-hidden">
                                <div class="flex justify-between">
                                    <span class="font-bold text-[#141823] text-[13px] truncate {{ $isActive ? 'text-black' : '' }}">{{ $conv['user']->name }}</span>
                                    <span class="text-[10px] text-gray-400 whitespace-nowrap">{{ $conv['last_message']->created_at->format('H:i') }}</span>
                                </div>
                                <div class="text-[11px] text-gray-500 truncate">
                                    @if($conv['last_message']->sender_id === auth()->id())
                                        <span class="text-gray-400">Tú:</span>
                                    @endif
                                    {{ $conv['last_message']->body }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 text-center text-gray-400 text-[12px]">
                            @if(isset($isArchivedView) && $isArchivedView)
                                No tienes mensajes archivados.
                            @else
                                No tienes mensajes nuevos.
                            @endif
                        </div>
                    @endforelse
                </div>

                <div class="p-2 text-center border-t border-[#e9eaed] text-[11px] shrink-0">
                    @if(isset($isArchivedView) && $isArchivedView)
                        <a href="{{ route('messages.index') }}" class="text-[#3b5998] cursor-pointer hover:underline font-bold">
                            ← Volver a la Bandeja de Entrada
                        </a>
                    @else
                        <a href="{{ route('messages.archived') }}" class="text-[#3b5998] cursor-pointer hover:underline">
                            Ver archivados
                        </a>
                    @endif
                </div>
            </div>

            <div class="inbox-content">
                
                @if(isset($user))
                    <div class="msg-header shrink-0">
                        <div>
                            <h2 class="text-[14px] font-bold text-[#141823] inline-block mr-2">
                                <a href="{{ route('users.show', $user) }}" class="hover:underline text-[#141823]">{{ $user->name }}</a>
                            </h2>
                            <span class="text-[11px] text-gray-500">· Larabook User</span>
                        </div>
                        <div class="flex gap-3 text-gray-500 font-bold text-[12px] items-center">
                            
                            @if(!isset($isArchivedView)) 
                                <form action="{{ route('messages.archive', $user) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="text-gray-500 hover:text-[#333] cursor-pointer bg-transparent border-none font-bold text-[12px] p-0">
                                        Archivar x
                                    </button>
                                </form>
                            @endif

                            <span class="cursor-pointer hover:text-[#333]">Acciones ▼</span>
                            <span class="cursor-pointer hover:text-[#333]">🔍</span>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-0 bg-white" id="messages-container">
                        @foreach($chat as $message)
                            <div class="msg-row {{ $message->sender_id === auth()->id() ? 'msg-own' : '' }}">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($message->sender->name) }}&background=random" class="w-10 h-10 border border-gray-300 shrink-0">
                                <div class="max-w-[80%]">
                                    <div class="text-[13px] font-bold text-[#3b5998] cursor-pointer hover:underline mb-0.5">
                                        {{ $message->sender_id === auth()->id() ? 'Tú' : $message->sender->name }}
                                    </div>
                                    <p class="text-[13px] text-[#141823] whitespace-pre-wrap">{{ $message->body }}</p>
                                    <span class="text-[10px] text-gray-400 block mt-1">{{ $message->created_at->format('d/m H:i') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-[#f2f2f2] border-t border-[#bdc7d8] p-3 shrink-0">
                        <form action="{{ route('messages.store', $user) }}" method="POST">
                            @csrf
                            <textarea name="body" class="w-full h-16 border border-[#bdc7d8] p-1 text-[13px] font-sans resize-none focus:border-[#3b5998] focus:outline-none mb-2" placeholder="Escribe una respuesta..."></textarea>
                            
                            <div class="flex justify-between items-center">
                                <div class="flex gap-3 text-[11px] text-[#3b5998]">
                                    <label class="flex items-center gap-1 cursor-pointer">
                                        <input type="checkbox"> <span class="font-bold">Añadir archivos</span>
                                    </label>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn-reply">Responder</button>
                                </div>
                            </div>
                        </form>
                    </div>

                @else
                    <div class="flex flex-col items-center justify-center h-full text-gray-400 bg-white">
                        <div class="text-6xl mb-4 opacity-30">✉️</div>
                        <h3 class="text-lg font-bold text-gray-500">Bandeja de Entrada</h3>
                        <p class="text-[12px] mt-2">Selecciona una conversación de la izquierda.</p>
                    </div>
                @endif

            </div>
        </div>
        
        <div class="text-center mt-2 text-[11px] text-gray-500 shrink-0">
            Larabook Chat © 2026
        </div>

    </div>

    @if(isset($user))
    <script>
        var container = document.getElementById("messages-container");
        if(container) {
            container.scrollTop = container.scrollHeight;
        }
    </script>
    @endif

</body>
</html>