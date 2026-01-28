<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* ESTILO RETRO 2012 */
        body { 
            background-color: #e9ebee; 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
            font-size: 11px; /* Letra pequeña clásica */
            color: #141823;
        }
        
        /* Colores Oficiales */
        .fb-dark-blue { background-color: #3b5998; }
        .fb-border { border: 1px solid #d3d6db; }
        .fb-link { color: #3b5998; font-weight: bold; cursor: pointer; }
        .fb-link:hover { text-decoration: underline; }
        .fb-gray-text { color: #9197a3; }
        
        /* Botones */
        .btn-post {
            background-color: #4e69a2;
            border: 1px solid #435a8b;
            color: white;
            font-weight: bold;
            font-size: 12px;
            padding: 4px 12px;
        }
        .btn-post:hover { background-color: #425f94; }

        /* Scrollbar oculta para mantener limpieza */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body>

    <nav class="fb-dark-blue fixed top-0 w-full z-50 h-[42px] border-b border-[#29487d] flex items-center justify-between px-4 md:px-20 shadow-sm">
        
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="bg-white text-[#3b5998] w-6 h-6 rounded-[2px] flex items-center justify-center font-bold text-lg pb-1 hover:opacity-90">
                L
            </a>
            
            <div class="hidden md:flex bg-white rounded-[3px] border border-[#203a6d] h-6 items-center w-[350px]">
                <input type="text" placeholder="Busca personas, lugares y cosas" class="w-full px-2 text-sm bg-transparent focus:outline-none placeholder-gray-500">
                <div class="bg-[#f2f2f2] h-full px-2 flex items-center border-l border-gray-300 cursor-pointer">
                    🔍
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 text-white font-bold text-xs">
            <a href="{{ route('users.show', auth()->user()) }}" class="flex items-center gap-2 hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-5 h-5 bg-white p-[1px]">
                <span>{{ Auth::user()->name }}</span>
            </a>
            <div class="h-4 border-r border-[#5470ad] mx-1"></div>
            <a href="{{ route('dashboard') }}" class="hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">Inicio</a>
            
            <div class="flex gap-1 ml-2 opacity-80">
                <div class="cursor-pointer hover:opacity-100 p-1">👥</div>
                <div class="cursor-pointer hover:opacity-100 p-1">💬</div>
                <div class="cursor-pointer hover:opacity-100 p-1">🌍</div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:text-gray-300 ml-2 font-normal text-[10px] transform scale-x-150">▼</button>
            </form>
        </div>
    </nav>

    <div class="pt-14 grid grid-cols-1 md:grid-cols-[180px_500px_1fr] justify-center gap-3 max-w-[980px] mx-auto px-2">
        
        <div class="hidden md:block text-[#141823]">
            <ul class="space-y-1">
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-4 h-4 rounded-[2px]">
                    <span class="font-bold text-xs">{{ Auth::user()->name }}</span>
                </li>
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">📰</span> <span class="text-xs">Noticias</span>
                </li>
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">💬</span> 
                    <a href="{{ route('messages.index') }}" class="text-xs hover:underline text-[#141823] font-bold">
                        Mensajes <span class="text-gray-400 font-normal">(1 nuevo)</span>
                    </a>
                </li>
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">📅</span> <span class="text-xs">Eventos</span>
                </li>
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">📷</span> <span class="text-xs">Fotos</span>
                </li>
            </ul>
            
            <div class="mt-4 mb-1 uppercase text-[#9197a3] font-bold text-[10px] px-1">APLICACIONES</div>
            <ul class="space-y-1">
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">🎮</span>
                    <a href="{{ route('games') }}" class="text-xs hover:underline text-[#141823]">Juegos</a>
                </li>
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">🎵</span> <span class="text-xs hover:underline">Música</span>
                </li>
            </ul>
        </div>
        
        <div class="flex flex-col gap-3 pb-10">
            
            <div class="bg-white fb-border rounded-[2px]">
                <div class="bg-[#f6f7f9] border-b border-[#e9eaed] px-3 py-2 flex gap-4 text-xs font-bold text-[#4b4f56]">
                    <div class="flex items-center gap-1 cursor-pointer text-[#1d2129]">
                        ✏️ <span class="hover:underline">Actualizar estado</span>
                    </div>
                    <div class="flex items-center gap-1 cursor-pointer text-[#3b5998] border-l border-gray-300 pl-4">
                        📷 <span class="hover:underline">Agregar fotos/video</span>
                    </div>
                </div>

                <div class="p-3">
                    <div class="flex gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-8 h-8 rounded-[2px] border border-gray-200">
                        <form action="{{ route('posts.store') }}" method="POST" class="w-full">
                            @csrf
                            <textarea name="content" rows="2" placeholder="¿Qué estás pensando?" 
                                   class="w-full border-none focus:ring-0 resize-none text-sm placeholder-gray-500 mt-1"></textarea>
                            
                            <div class="border-t border-[#e9eaed] pt-2 mt-2 flex justify-between items-center">
                                <div class="flex gap-3">
                                    <span class="text-gray-400 cursor-pointer">👤</span>
                                    <span class="text-gray-400 cursor-pointer">📍</span>
                                </div>
                                <button type="submit" class="btn-post rounded-[2px]">Publicar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($posts as $post)
            <div class="bg-white fb-border rounded-[2px] p-3">
                <div class="flex gap-2 mb-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" class="w-10 h-10 rounded-[2px] border border-gray-200">
                    <div>
                        <a href="{{ route('users.show', $post->user) }}" class="fb-link text-[13px] block leading-tight">
                            {{ $post->user->name }}
                        </a>
                        <span class="text-[11px] text-[#9197a3] cursor-pointer hover:underline">
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                
                <p class="text-[13px] text-[#141823] mb-2 leading-snug">
                    {{ $post->content }}
                </p>

                <div class="text-[11px] font-bold text-[#3b5998] flex gap-4 mt-1">
                    <span class="cursor-pointer hover:underline">Me gusta</span>
                    <span class="cursor-pointer hover:underline">Comentar</span>
                    <span class="cursor-pointer hover:underline">Compartir</span>
                </div>
                
                <div class="bg-[#f6f7f9] border-t border-[#e9eaed] mt-2 px-2 py-1 flex items-center gap-1 text-[11px] text-[#4b4f56]">
                    <span>👍</span> <span class="hover:underline cursor-pointer">A una persona le gusta esto.</span>
                </div>
            </div>
            @endforeach

        </div>

        <div class="hidden lg:block w-[240px] pl-2">
            
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[#9197a3] font-bold text-[11px] uppercase">Publicidad</span>
                    <span class="text-[#3b5998] text-[11px] cursor-pointer hover:underline">Crear anuncio</span>
                </div>
                
                <div class="flex gap-2 mb-2 cursor-pointer group">
                    <div class="w-[90px] h-[60px] bg-gray-300 border border-gray-400 overflow-hidden">
                        <img src="https://picsum.photos/100/100?random=1" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <div class="fb-link text-[11px] group-hover:underline">Aprende Laravel Hoy</div>
                        <div class="text-[11px] text-[#141823]">larabook.com</div>
                        <div class="text-[10px] text-[#9197a3] mt-1">Curso intensivo.</div>
                    </div>
                </div>
            </div>

            <div class="border-b border-[#d3d6db] my-3"></div>

            <div class="mb-4">
                 <span class="text-[#9197a3] font-bold text-[11px] uppercase mb-2 block">Personas que quizás conozcas</span>
                 @for ($i = 0; $i < 3; $i++)
                 <div class="flex items-center gap-2 mb-2">
                    <img src="https://i.pravatar.cc/100?img={{ $i + 30 }}" class="w-9 h-9 border border-gray-200">
                    <div>
                        <div class="fb-link text-[11px] leading-tight">Amigo {{ $i + 1 }}</div>
                        <div class="text-[10px] text-[#9197a3] mb-0.5">1 amigo en común</div>
                        <button class="bg-[#f6f7f9] border border-[#ced0d4] text-[#4b4f56] font-bold text-[10px] px-1 py-0.5 hover:bg-[#e9ebee]">
                            +1 Agregar a amigos
                        </button>
                    </div>
                 </div>
                 @endfor
            </div>

        </div>
    </div>

    <div class="fixed right-0 bottom-0 w-[205px] bg-[#e9eaed] border-l border-t border-[#bdc7d8] hidden xl:flex flex-col z-50 h-[calc(100vh-42px)]">
        
        <div class="p-2 font-bold text-[#333] text-[11px] border-b border-[#d8dfea] flex justify-between items-center cursor-pointer hover:bg-[#eff1f3]">
            <span>Chat (18)</span>
            <span class="text-gray-500">⚙️</span>
        </div>

        <div class="overflow-y-auto flex-1 p-1 space-y-1 no-scrollbar bg-[#e9eaed]">
            @for($i=0; $i<15; $i++)
            <div class="flex items-center gap-2 p-1.5 hover:bg-[#d8dfea] cursor-pointer rounded-[2px] group">
                <img src="https://i.pravatar.cc/100?img={{ $i + 10 }}" class="w-6 h-6 border border-gray-300">
                
                <div class="flex-1 flex justify-between items-center">
                    <span class="text-[11px] text-[#141823] group-hover:underline">Amigo {{ $i + 1 }}</span>
                    <div class="w-1.5 h-1.5 bg-[#62c462] rounded-full border border-[#489a48]"></div>
                </div>
            </div>
            @endfor
        </div>

        <div class="p-1 border-t border-[#bdc7d8] bg-[#f6f7f9]">
            <input type="text" placeholder="Buscar" class="w-full border border-[#bdc7d8] text-[11px] px-1 py-0.5">
        </div>
    </div>

    <div class="fixed bottom-0 right-[215px] w-[260px] bg-white border border-[#bdc7d8] border-b-0 rounded-t-[3px] shadow-sm z-50 hidden md:flex flex-col">
        
        <div class="bg-[#e9eaed] border-b border-[#bdc7d8] p-1.5 flex justify-between items-center cursor-pointer hover:bg-[#d8dfea] rounded-t-[3px]">
            <div class="flex items-center gap-1.5">
                <div class="w-1.5 h-1.5 bg-[#62c462] rounded-full"></div>
                <span class="text-[#333] font-bold text-[11px] hover:underline">Juan Dev</span>
            </div>
            <div class="flex gap-2 text-gray-500 font-bold text-[12px]">
                <span>⚙️</span>
                <span>✖</span>
            </div>
        </div>

        <div class="h-[200px] overflow-y-auto p-2 bg-white border-b border-[#bdc7d8] space-y-2">
            <div class="flex gap-1.5">
                <img src="https://i.pravatar.cc/100?img=50" class="w-6 h-6 border border-gray-300">
                <div class="text-[11px] text-[#141823]">
                    <span class="text-[#3b5998] font-bold cursor-pointer hover:underline">Juan</span>
                    <span>Oye, ¿viste el nuevo diseño de Larabook?</span>
                </div>
            </div>
            <div class="flex gap-1.5">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-6 h-6 border border-gray-300">
                <div class="text-[11px] text-[#141823]">
                    <span class="text-[#3b5998] font-bold cursor-pointer hover:underline">Tú</span>
                    <span>Siii, quedó idéntico al 2012. ¡Es increíble!</span>
                </div>
            </div>
        </div>

        <div class="p-1.5">
            <input type="text" class="w-full border border-[#bdc7d8] p-1 text-[11px] focus:outline-none focus:border-[#3b5998]" autofocus>
        </div>
    </div>
</body>
</html>