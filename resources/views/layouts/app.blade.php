<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Larabook')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif; color: #1d2129; }
        
        /* Navbar Styles */
        .fb-blue-nav { background-color: #4267b2; border-bottom: 1px solid #29487d; }
        .nav-item { padding: 0 10px; height: 28px; line-height: 28px; border-radius: 2px; text-decoration: none; color: white; font-size: 12px; font-weight: bold; }
        .nav-item:hover { background-color: rgba(0, 0, 0, .1); }
        
        /* Search Input */
        .search-input { border: 1px solid #1d4085; border-radius: 2px; height: 24px; padding-left: 5px; font-size: 12px; width: 100%; outline: none; }
        .search-btn { background: #f5f6f7; border: 1px solid #1d4085; border-left: none; height: 24px; width: 40px; border-top-right-radius: 2px; border-bottom-right-radius: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .search-btn:hover { background-color: #e9ebee; }

        /* General Utilities */
        .card { background: white; border: 1px solid #dddfe2; border-radius: 3px; margin-bottom: 10px; }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="fb-blue-nav h-[42px] flex items-center justify-center sticky top-0 z-50 shadow-sm">
        <div class="w-[1012px] flex justify-between items-center px-2 h-full">
            
            <div class="flex items-center gap-2 flex-grow">
                <a href="{{ route('dashboard') }}" class="no-underline">
                    <div class="bg-white text-[#4267b2] w-[24px] h-[24px] font-bold text-xl flex items-center justify-center rounded-[2px] pb-2 select-none">
                        l
                    </div>
                </a>
                
                <div class="flex items-center w-[400px] ml-1 relative">
                    <input type="text" placeholder="Buscar" class="search-input rounded-r-none">
                    <button class="search-btn">
                        <svg class="w-3 h-3 text-[#4b4f56]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
            
            <div class="flex items-center gap-2 text-white ml-4">
                <a href="#" class="nav-item flex items-center gap-2">
                    <img src="{{ Auth::user()->avatar }}" class="w-5 h-5 rounded-full border border-black/10 bg-white">
                    {{ Auth::user()->first_name }}
                </a>
                <a href="{{ route('dashboard') }}" class="nav-item">Inicio</a>
                <a href="#" class="nav-item">Crear</a>
                
                <div class="border-l border-[rgba(0,0,0,.1)] h-4 mx-1"></div>
                
                <div class="flex gap-3 px-2 opacity-80">
                    <button class="cursor-pointer hover:opacity-100" title="Solicitudes">👥</button>
                    <button class="cursor-pointer hover:opacity-100" title="Messenger">💬</button>
                    <button class="cursor-pointer hover:opacity-100" title="Notificaciones">🔔</button>
                </div>
                
                <div class="border-l border-[rgba(0,0,0,.1)] h-4 mx-1"></div>

                <div class="relative group">
                    <button class="nav-item text-[10px] px-1">▼</button>
                    <div class="absolute right-0 top-6 w-40 bg-white border border-[#dddfe2] shadow-lg rounded hidden group-hover:block z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-sm hover:bg-[#4267b2] hover:text-white text-[#1d2129]">
                                Salir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="w-[1012px] mx-auto mt-3">
        @yield('content')
    </main>
    
    @stack('scripts')
</body>
</html>