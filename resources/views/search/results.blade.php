<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Búsqueda: {{ $query }} | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 11px; color: #141823; }
        .fb-dark-blue { background-color: #3b5998; }
        .fb-container { width: 851px; margin: 20px auto; background: #fff; border: 1px solid #d3d6db; border-radius: 3px; min-height: 400px; }
        .fb-header-gray { background-color: #f6f7f9; padding: 10px 12px; border-bottom: 1px solid #e9eaed; font-weight: bold; font-size: 14px; color: #4b4f56; }
        .section-header { background-color: #f6f7f9; padding: 8px 12px; border-bottom: 1px solid #e9eaed; font-weight: bold; font-size: 12px; color: #90949c; text-transform: uppercase; margin-top: 10px; }
        .result-item { padding: 12px; border-bottom: 1px solid #e9eaed; display: flex; gap: 10px; align-items: center; }
        .link-name { color: #3b5998; font-weight: bold; font-size: 14px; text-decoration: none; }
        .link-name:hover { text-decoration: underline; }
        .fb-btn-gray { background: linear-gradient(#f6f7f9, #ebedf0); border: 1px solid #ced0d4; color: #4b4f56; font-weight: bold; padding: 4px 8px; cursor: pointer; }
    </style>
</head>
<body>

    <nav class="fb-dark-blue fixed top-0 w-full z-50 h-[42px] border-b border-[#29487d] flex items-center justify-between px-4 md:px-20 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="bg-white text-[#3b5998] w-6 h-6 rounded-[2px] flex items-center justify-center font-bold text-lg pb-1 hover:opacity-90">L</a>
            
            <form action="{{ route('search') }}" method="GET" class="hidden md:flex bg-white rounded-[3px] border border-[#203a6d] h-6 items-center w-[350px]">
                <input type="text" name="q" value="{{ $query }}" placeholder="Busca personas, lugares y cosas" class="w-full px-2 text-sm bg-transparent focus:outline-none placeholder-gray-500">
                <button type="submit" class="bg-[#f2f2f2] h-full px-2 flex items-center border-l border-gray-300 cursor-pointer">🔍</button>
            </form>
        </div>
        <div class="flex items-center gap-4 text-white font-bold text-xs">
            <a href="{{ route('dashboard') }}" class="hover:underline">Inicio</a>
        </div>
    </nav>

    <div class="pt-14 pb-20">
        <div class="fb-container">
            <div class="fb-header-gray">
                Resultados de la búsqueda para "{{ $query }}"
            </div>

            @if($users->isEmpty() && $pages->isEmpty())
                <div class="p-10 text-center text-gray-500">
                    <p class="text-lg mb-2">No encontramos resultados para tu búsqueda.</p>
                    <p>Intenta verificar la ortografía o buscar algo más general.</p>
                </div>
            @else
                
                @if(!$users->isEmpty())
                    <div class="section-header">Personas</div>
                    @foreach($users as $user)
                        <div class="result-item">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="w-[50px] h-[50px] border border-gray-300">
                            <div class="flex-1 flex justify-between items-center">
                                <div>
                                    <a href="{{ route('users.show', $user) }}" class="link-name">
                                        {{ $user->name }}
                                    </a>
                                    <div class="text-[#90949c] text-[11px]">
                                        Usuario de Larabook
                                    </div>
                                </div>
                                <a href="{{ route('users.show', $user) }}" class="fb-btn-gray text-[12px] decoration-none flex items-center gap-1">
                                    <span class="text-[14px] font-bold text-[#3b5998]">+1</span> Agregar a amigos
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if(!$pages->isEmpty())
                    <div class="section-header">Páginas</div>
                    @foreach($pages as $page)
                        <div class="result-item">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($page->name) }}&background=white&color=333&bold=true" class="w-[50px] h-[50px] border border-gray-300">
                            <div class="flex-1 flex justify-between items-center">
                                <div>
                                    <a href="{{ route('pages.show', $page->slug) }}" class="link-name">
                                        {{ $page->name }}
                                    </a>
                                    <div class="text-[#90949c] text-[11px]">
                                        {{ $page->category }} • {{ $page->fans->count() }} Me gusta
                                    </div>
                                </div>
                                <a href="{{ route('pages.show', $page->slug) }}" class="fb-btn-gray text-[12px] decoration-none flex items-center gap-1">
                                    👍 Me gusta
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif

            @endif
        </div>
    </div>
    
    @include('partials.chat-overlay')
</body>
</html>