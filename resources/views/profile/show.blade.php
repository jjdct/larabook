<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->name }} | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* ESTILO RETRO TIMELINE 2012 */
        body { 
            background-color: #e9ebee; 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
            font-size: 11px;
            color: #141823;
        }
        .fb-dark-blue { background-color: #3b5998; }
        .fb-timeline-cover {
            width: 100%;
            height: 315px;
            background: linear-gradient(to bottom, #7f8c8d, #95a5a6);
            position: relative;
            border: 1px solid #000;
            border-bottom: none;
        }
        .fb-profile-pic {
            width: 160px;
            height: 160px;
            border: 4px solid white;
            position: absolute;
            bottom: -30px;
            left: 20px;
            background: white;
            box-shadow: 0 1px 1px rgba(0,0,0,.3);
            z-index: 10;
        }
        .fb-timeline-nav {
            background-color: white;
            border: 1px solid #d3d6db;
            border-top: none;
            height: 42px;
            border-radius: 0 0 3px 3px;
        }
        /* Botón Gris Estándar */
        .fb-btn-gray {
            background: linear-gradient(#f6f7f9, #ebedf0);
            border: 1px solid #ced0d4;
            color: #4b4f56;
            font-weight: bold;
            font-size: 12px;
            padding: 4px 10px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 28px;
        }
        .fb-btn-gray:hover { background: #e9ebee; }

        /* Botón Verde */
        .fb-btn-green {
            background-color: #42b72a;
            border: 1px solid #2c8415;
            color: white;
            font-weight: bold;
            font-size: 12px;
            padding: 0 10px;
            cursor: pointer;
            height: 28px;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 1px 0 rgba(0,0,0,.1);
        }
        .fb-btn-green:hover { background-color: #36a020; }

        .fb-box {
            background: white;
            border: 1px solid #d3d6db;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        .fb-link { color: #3b5998; cursor: pointer; text-decoration: none; }
        .fb-link:hover { text-decoration: underline; }
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

    <div class="pt-12 max-w-[851px] mx-auto pb-20">
        
        <div class="relative mb-4">
            <div class="fb-timeline-cover overflow-hidden group cursor-pointer">
                <img src="https://picsum.photos/seed/{{ $user->id }}/851/315" class="w-full h-full object-cover">
                
                <h1 class="absolute bottom-4 left-[200px] text-white text-[30px] font-bold shadow-black drop-shadow-md leading-none">
                    {{ $user->name }}
                </h1>

                @if(auth()->id() === $user->id)
                <button class="hidden group-hover:block absolute bottom-4 right-4 fb-btn-gray shadow border-black opacity-90">
                    📷 Cambiar portada
                </button>
                @endif
            </div>

            <div class="fb-timeline-nav flex items-center pl-[200px] pr-4 justify-between">
                
                <div class="flex h-full">
                    <div class="px-4 h-full flex items-center font-bold text-[#4b4f56] border-r border-[#e9eaed] cursor-pointer hover:bg-[#f6f7f9] text-[12px]">Biografía</div>
                    <div class="px-4 h-full flex items-center font-bold text-[#3b5998] border-r border-[#e9eaed] cursor-pointer hover:bg-[#f6f7f9] text-[12px]">Información</div>
                    <div class="px-4 h-full flex items-center font-bold text-[#3b5998] border-r border-[#e9eaed] cursor-pointer hover:bg-[#f6f7f9] text-[12px]">Amigos <span class="text-[#9197a3] ml-1 font-normal">0</span></div>
                    <div class="px-4 h-full flex items-center font-bold text-[#3b5998] border-r border-[#e9eaed] cursor-pointer hover:bg-[#f6f7f9] text-[12px]">Fotos</div>
                    <div class="px-4 h-full flex items-center font-bold text-[#3b5998] cursor-pointer hover:bg-[#f6f7f9] text-[12px]">Más ▼</div>
                </div>
                
                <div class="flex gap-2 items-center">
                    @if(auth()->id() === $user->id)
                        <a href="{{ route('profile.edit') }}" class="fb-btn-gray">Actualizar información</a>
                        <button class="fb-btn-gray">Registro de actividad</button>
                    @else
                        @if(auth()->user()->isFriendWith($user->id))
                            <button class="fb-btn-gray cursor-default group">
                                <span class="text-green-600 mr-1 text-[14px]">✓</span> Amigos
                            </button>

                        @elseif(auth()->user()->hasReceivedRequestFrom($user))
                            <form action="{{ route('friends.accept', $user) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="fb-btn-green mr-1">Confirmar</button>
                            </form>
                            <form action="{{ route('friends.reject', $user) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="fb-btn-gray">Eliminar</button>
                            </form>

                        @elseif(auth()->user()->hasSentRequestTo($user))
                            <button class="fb-btn-gray text-[#4b4f56] cursor-default">
                                Solicitud enviada
                            </button>

                        @else
                            <form action="{{ route('friends.add', $user->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="fb-btn-green">
                                    <span class="mr-1 text-[14px]">+1</span> Agregar a mis amigos
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('messages.show', $user) }}" class="fb-btn-gray">💬 Mensaje</a>
                        <button class="fb-btn-gray px-2">...</button>
                    @endif
                </div>

            </div>

            <div class="fb-profile-pic overflow-hidden group cursor-pointer">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=160" class="w-full h-full">
                @if(auth()->id() === $user->id)
                <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white text-center py-1 text-[10px] hidden group-hover:block">
                    Editar foto
                </div>
                @endif
            </div>
        </div>

        <div class="flex gap-3">
            
            <div class="w-[300px]">
                
                <div class="fb-box p-3">
                    <h3 class="text-[#4b4f56] font-bold text-[12px] mb-2">Presentación</h3>
                    <div class="text-center py-4 border-b border-[#e9eaed] mb-2">
                        <span class="text-[#9197a3] text-[11px]">Escribe algo sobre ti...</span>
                    </div>
                    <div class="text-[11px] text-[#141823] space-y-2">
                        <div class="flex gap-2"><span class="text-gray-400">💼</span> Trabaja en <span class="fb-link">Larabook Inc.</span></div>
                        <div class="flex gap-2"><span class="text-gray-400">🎓</span> Estudió en <span class="fb-link">Universidad del Código</span></div>
                        <div class="flex gap-2"><span class="text-gray-400">🏠</span> Vive en <span class="fb-link">Internet</span></div>
                        <div class="flex gap-2"><span class="text-gray-400">📍</span> De <span class="fb-link">Tu Servidor Local</span></div>
                    </div>
                </div>

                <div class="fb-box p-3">
                    <h3 class="fb-link font-bold text-[12px] mb-3">Fotos</h3>
                    <div class="grid grid-cols-3 gap-1">
                        @for($i=0; $i<9; $i++)
                        <div class="bg-gray-200 h-20 border border-gray-300"></div>
                        @endfor
                    </div>
                </div>

                <div class="fb-box p-3">
                    <h3 class="fb-link font-bold text-[12px] mb-3">Amigos <span class="text-gray-400 font-normal">0</span></h3>
                    <div class="grid grid-cols-3 gap-2">
                        <p class="text-[11px] text-gray-500 col-span-3">No hay amigos que mostrar.</p>
                    </div>
                </div>
            </div>

            <div class="w-[536px]">
                
                @if(auth()->id() === $user->id)
                <div class="fb-box">
                    <div class="bg-[#f6f7f9] border-b border-[#e9eaed] px-3 py-2 text-xs font-bold text-[#4b4f56]">
                        ✏️ Actualizar estado
                    </div>
                    <div class="p-3">
                        <form action="{{ route('posts.store') }}" method="POST">
                            @csrf
                            <div class="flex gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" class="w-8 h-8 square">
                                <textarea name="content" rows="2" placeholder="¿Qué estás pensando?" 
                                        class="w-full border-none focus:ring-0 resize-none text-sm placeholder-gray-500"></textarea>
                            </div>
                            <div class="border-t border-[#e9eaed] mt-2 pt-2 text-right">
                                <button type="submit" class="bg-[#4e69a2] text-white border border-[#435a8b] font-bold text-[12px] px-3 py-1 hover:bg-[#425f94]">Publicar</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                @foreach ($posts as $post)
                    @include('partials.post', ['post' => $post])
                @endforeach

            </div>
        </div>
    </div>

    @include('partials.chat-overlay')
</body>
</html>