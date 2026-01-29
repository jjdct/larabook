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
            font-size: 11px;
            color: #141823;
        }
        
        .fb-dark-blue { background-color: #3b5998; }
        .fb-border { border: 1px solid #d3d6db; }
        .fb-link { color: #3b5998; font-weight: bold; cursor: pointer; text-decoration: none; }
        .fb-link:hover { text-decoration: underline; }
        
        .btn-post {
            background-color: #4e69a2;
            border: 1px solid #435a8b;
            color: white;
            font-weight: bold;
            font-size: 12px;
            padding: 4px 12px;
            cursor: pointer;
        }
        .btn-post:hover { background-color: #425f94; }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
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

    <div class="pt-14 grid grid-cols-1 md:grid-cols-[180px_500px_1fr] justify-center gap-3 max-w-[980px] mx-auto px-2">
        
        <div class="hidden md:block text-[#141823]">
            <ul class="space-y-1">
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-4 h-4 rounded-[2px]">
                    <a href="{{ route('users.show', auth()->user()) }}" class="font-bold text-xs fb-link">{{ Auth::user()->name }}</a>
                </li>
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">📰</span> <span class="text-xs">Noticias</span>
                </li>
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">💬</span> 
                    <a href="{{ route('messages.index') }}" class="text-xs hover:underline text-[#141823] font-bold">
                        Mensajes
                    </a>
                </li>
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">📅</span> <span class="text-xs">Eventos</span>
                </li>
                <li class="flex items-center gap-2 p-1 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <span class="text-sm">🚩</span> 
                    <a href="{{ route('pages.create') }}" class="text-xs hover:underline text-[#141823]">
                        Crear Página
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="flex flex-col gap-3 pb-10">
            
            <div class="bg-white fb-border rounded-[2px]">
                <div class="bg-[#f6f7f9] border-b border-[#e9eaed] px-3 py-2 flex gap-4 text-xs font-bold text-[#4b4f56]">
                    <div class="flex items-center gap-1 cursor-pointer text-[#1d2129]">
                        ✏️ <span class="hover:underline">Actualizar estado</span>
                    </div>
                    <div class="flex items-center gap-1 cursor-pointer text-[#3b5998] border-l border-gray-300 pl-4" onclick="document.getElementById('post-image').click()">
                        📷 <span class="hover:underline">Agregar fotos/video</span>
                    </div>
                </div>

                <div class="p-3">
                    <div class="flex gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-8 h-8 rounded-[2px] border border-gray-200">
                        
                        <form action="{{ route('posts.store') }}" method="POST" class="w-full" enctype="multipart/form-data">
                            @csrf
                            
                            <textarea name="content" rows="2" placeholder="¿Qué estás pensando?" 
                                   class="w-full border-none focus:ring-0 resize-none text-sm placeholder-gray-500 mt-1"></textarea>
                            
                            <input type="file" name="image" id="post-image" class="hidden" accept="image/*" onchange="alert('📷 Foto seleccionada: ' + this.files[0].name)">
                            
                            @error('content')
                                <div class="text-red-500 text-[10px] mt-1">{{ $message }}</div>
                            @enderror
                            @error('image')
                                <div class="text-red-500 text-[10px] mt-1">{{ $message }}</div>
                            @enderror

                            <div class="border-t border-[#e9eaed] pt-2 mt-2 flex justify-between items-center">
                                <div class="flex gap-3"></div>
                                <button type="submit" class="btn-post rounded-[2px]">Publicar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($posts as $post)
                @include('partials.post', ['post' => $post])
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.chat-overlay')

</body>
</html>