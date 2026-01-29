<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Str::limit($post->content, 20) }} | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 11px; color: #141823; }
        .fb-dark-blue { background-color: #3b5998; }
        .fb-border { border: 1px solid #d3d6db; }
        .fb-link { color: #3b5998; font-weight: bold; cursor: pointer; text-decoration: none; }
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
        </div>
    </nav>

    <div class="pt-16 max-w-[600px] mx-auto pb-20">
        
        <div class="flex items-center gap-2 mb-4 text-[#3b5998] font-bold text-xs">
            <a href="{{ url()->previous() }}">← Volver al muro</a>
        </div>

        @include('partials.post', ['post' => $post])

    </div>

    @include('partials.chat-overlay')

</body>
</html>