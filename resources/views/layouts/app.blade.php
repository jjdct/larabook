<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Larabook')</title>

    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif; color: #1d2129; margin: 0; padding: 0; }
        
        /* Navbar Styles */
        .fb-blue-nav { background-color: #4267b2; border-bottom: 1px solid #29487d; }
        .nav-item { padding: 0 10px; height: 28px; line-height: 28px; border-radius: 2px; text-decoration: none; color: white; font-size: 12px; font-weight: bold; cursor: pointer; display: inline-block; }
        .nav-item:hover { background-color: rgba(0, 0, 0, .1); }
        
        /* Search Input */
        .search-input { border: 1px solid #1d4085; border-radius: 2px; height: 24px; padding-left: 5px; font-size: 12px; width: 100%; outline: none; }
        .search-btn { background: #f5f6f7; border: 1px solid #1d4085; border-left: none; height: 24px; width: 40px; border-top-right-radius: 2px; border-bottom-right-radius: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .search-btn:hover { background-color: #e9ebee; }

        /* General Utilities */
        .card { background: white; border: 1px solid #dddfe2; border-radius: 3px; margin-bottom: 10px; }

        /* Badges y Dropdowns */
        .badge-red {
            position: absolute; top: -5px; right: -2px;
            background-color: #fa3e3e; color: white;
            font-size: 10px; font-weight: bold;
            padding: 0px 4px; border-radius: 2px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.2);
            z-index: 10;
        }
        .custom-dropdown {
            position: absolute; top: 30px; right: 0;
            width: 350px;
            background: white;
            border: 1px solid #dddfe2; border-radius: 0 0 3px 3px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .25);
            z-index: 100;
            color: #1d2129;
            cursor: default;
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="fb-blue-nav h-[42px] flex items-center justify-center sticky top-0 z-50 shadow-sm">
        <div class="w-[1012px] flex justify-between items-center px-2 h-full">
            
            <div class="flex items-center gap-2 flex-grow">
                <a href="{{ Auth::check() ? route('dashboard') : url('/') }}" class="no-underline">
                    <div class="bg-white text-[#4267b2] w-[24px] h-[24px] font-bold text-xl flex items-center justify-center rounded-[2px] pb-2 select-none">
                        l
                    </div>
                </a>
                
                <form action="{{ route('search') }}" method="GET" class="flex items-center w-[400px] ml-1 relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar" class="search-input rounded-r-none">
                    <button type="submit" class="search-btn">
                        <svg class="w-3 h-3 text-[#4b4f56]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </button>
                </form>
            </div>
            
            <div class="flex items-center gap-2 text-white ml-4">
                
                @auth
                    <div class="flex items-center gap-2" x-data="{ openFriends: false, openMsgs: false, openNotifs: false }">
                        
                        <a href="{{ route('profile') }}" class="nav-item flex items-center gap-2">
                            <img src="{{ Auth::user()->avatar }}" class="w-5 h-5 rounded-full border border-black/10 bg-white object-cover">
                            <span class="hidden sm:inline">{{ Auth::user()->first_name }}</span>
                        </a>
                        <a href="{{ route('dashboard') }}" class="nav-item">Inicio</a>
                        <a href="{{ route('pages.create') }}" class="nav-item">Crear</a>
                        
                        <div class="border-l border-[rgba(0,0,0,.1)] h-4 mx-1"></div>
                        
                        <div class="flex gap-1 px-1 opacity-100 relative">
                            
                            <div class="relative">
                                <button @click="openFriends = !openFriends; openMsgs = false; openNotifs = false" @click.outside="openFriends = false" 
                                        class="nav-item opacity-60 hover:opacity-100 relative" title="Solicitudes">
                                    <span class="text-lg">👥</span>
                                    
                                    @php $pendingCount = Auth::user()->pendingFriendRequests->count(); @endphp
                                    @if($pendingCount > 0)
                                        <span class="badge-red">{{ $pendingCount }}</span>
                                    @endif
                                </button>

                                <div x-show="openFriends" class="custom-dropdown" style="display: none;">
                                    <div class="p-2 border-b border-[#dddfe2] text-xs font-bold text-[#4b4f56]">Solicitudes de amistad</div>
                                    <div class="max-h-[300px] overflow-y-auto bg-white">
                                        @forelse(Auth::user()->pendingFriendRequests as $requester)
                                            <div class="flex gap-2 p-2 border-b border-[#e9eaed] hover:bg-[#f5f6f7]">
                                                <a href="{{ route('profile.show', $requester->username) }}">
                                                    <img src="{{ $requester->avatar }}" class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                                                </a>
                                                <div class="flex-grow">
                                                    <div class="flex justify-between">
                                                        <a href="{{ route('profile.show', $requester->username) }}" class="text-sm font-bold text-[#365899] hover:underline">
                                                            {{ $requester->name }}
                                                        </a>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mb-1">Quiere ser tu amigo</div>
                                                    <div class="flex gap-1">
                                                        <form action="{{ route('friend.accept', $requester) }}" method="POST">
                                                            @csrf
                                                            <button class="bg-[#4267b2] hover:bg-[#365899] text-white text-xs font-bold px-3 py-1 rounded-sm border border-[#29487d]">
                                                                Confirmar
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('friend.reject', $requester) }}" method="POST">
                                                            @csrf
                                                            <button class="bg-[#f5f6f7] hover:bg-[#e9ebee] text-[#4b4f56] text-xs font-bold px-3 py-1 rounded-sm border border-[#ccd0d5]">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-4 text-center text-gray-500 text-sm">No tienes solicitudes nuevas.</div>
                                        @endforelse
                                    </div>
                                    <div class="p-1 text-center bg-[#f5f6f7] border-t border-[#dddfe2]">
                                        <a href="{{ route('friends.index') }}" class="text-xs text-[#365899] hover:underline">Ver todas</a>
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <button @click="openMsgs = !openMsgs; openFriends = false; openNotifs = false" @click.outside="openMsgs = false"
                                        class="nav-item opacity-60 hover:opacity-100" title="Messenger">
                                    <span class="text-lg">💬</span>
                                </button>
                                <div x-show="openMsgs" class="custom-dropdown" style="display: none;">
                                    <div class="p-2 border-b border-[#dddfe2] text-xs font-bold text-[#4b4f56]">Recientes</div>
                                    <div class="p-2 text-sm text-gray-500 hover:bg-[#f5f6f7] cursor-pointer">
                                        <strong>Sistema:</strong> Chat en construcción... 🛠️
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <button @click="openNotifs = !openNotifs; openFriends = false; openMsgs = false" @click.outside="openNotifs = false"
                                        class="nav-item opacity-60 hover:opacity-100 relative" title="Notificaciones">
                                    <span class="text-lg">🔔</span>
                                    
                                    {{-- Contador de no leídas --}}
                                    @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                                    @if($unreadCount > 0)
                                        <span class="badge-red">{{ $unreadCount }}</span>
                                    @endif
                                </button>

                                <div x-show="openNotifs" class="custom-dropdown" style="display: none;">
                                    {{-- Cabecera --}}
                                    <div class="p-2 border-b border-[#dddfe2] text-xs font-bold text-[#4b4f56] flex justify-between items-center">
                                        <span>Notificaciones</span>
                                        <form action="{{ route('notifications.readAll') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[#365899] hover:underline font-normal bg-transparent border-none cursor-pointer p-0">
                                                Marcar leídas
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Lista --}}
                                    <div class="max-h-[400px] overflow-y-auto bg-white">
                                        @forelse(Auth::user()->notifications as $notification)
                                            <div class="relative flex gap-2 p-2 border-b border-[#e9eaed] hover:bg-[#f5f6f7] cursor-pointer {{ $notification->read_at ? '' : 'bg-[#edf2fa]' }}">
                                                
                                                <a href="{{ route('notifications.show', $notification->id) }}" class="absolute inset-0 z-10"></a>
                                                
                                                <img src="{{ $notification->data['actor_avatar'] ?? 'https://ui-avatars.com/api/?name=User' }}" 
                                                     class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                                                
                                                <div class="flex-grow">
                                                    <div class="text-sm text-[#1d2129] leading-tight">
                                                        <strong>{{ $notification->data['actor_name'] }}</strong> 
                                                        {{ $notification->data['message'] }}
                                                    </div>
                                                    
                                                    <div class="text-xs text-[#90949c] mt-1 flex items-center gap-1">
                                                        
                                                        {{-- LOGICA DE ICONOS --}}
                                                        @if(($notification->data['type'] ?? '') == 'like') 
                                                            <span class="text-blue-500 text-[10px]">👍</span>
                                                        @elseif(($notification->data['type'] ?? '') == 'comment')
                                                            <span class="text-green-600 text-[10px]">💬</span>
                                                        @elseif(($notification->data['type'] ?? '') == 'friend_accepted')
                                                            {{-- ¡AQUÍ ESTÁ EL CAMBIO DE AMISTAD! --}}
                                                            <span class="text-[#42b72a] text-[10px]">🤝</span>
                                                        @endif
                                                        
                                                        {{ $notification->created_at->diffForHumans(null, true, true) }}
                                                        
                                                        @if(!$notification->read_at)
                                                            <span class="w-2 h-2 bg-[#4267b2] rounded-full inline-block ml-1"></span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-8 text-center text-gray-500 text-xs">
                                                <div class="text-xl mb-1">🔕</div>
                                                No tienes notificaciones.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="border-l border-[rgba(0,0,0,.1)] h-4 mx-1"></div>

                        <div class="relative group">
                            <button class="nav-item text-[10px] px-1 h-[20px] flex items-center text-[#1d2129] font-bold">▼</button>
                            <div class="absolute right-0 top-6 w-40 bg-white border border-[#dddfe2] shadow-lg rounded hidden group-hover:block z-50">
                                <div class="border-b border-[#dddfe2] p-2 text-xs text-gray-500">
                                     Larabook © 2026
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm hover:bg-[#4267b2] hover:text-white text-[#1d2129]">
                                        Salir
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="bg-[#42b72a] hover:bg-[#36a420] text-white text-xs font-bold px-3 py-1 rounded-[2px] border border-[#42b72a] no-underline">
                            Iniciar sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-[#4b4f56] text-xs font-bold px-3 py-1 rounded-[2px] border border-gray-400 no-underline">
                                Registrarte
                            </a>
                        @endif
                    </div>
                @endauth

            </div>
        </div>
    </nav>

    <main class="w-[1012px] mx-auto mt-3">
        @yield('content')
    </main>
    
    @stack('scripts')
</body>
</html>