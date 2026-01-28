<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Juegos | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-color: #e9ebee; 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
            font-size: 11px;
            color: #141823;
        }
        .fb-dark-blue { background-color: #3b5998; }
        
        /* Estilos específicos de Canvas Apps */
        .canvas-container {
            width: 760px; /* Ancho estándar de juegos de FB en 2012 */
            margin: 0 auto;
        }
        .app-header {
            background-color: white;
            border: 1px solid #bdc7d8;
            border-bottom: none;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 3px 3px 0 0;
        }
        .game-iframe-placeholder {
            width: 760px;
            height: 600px;
            background-color: #f1f1f1; /* Gris Flash */
            border: 1px solid #bdc7d8;
            display: flex;
            flex-col;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        /* Simulación del Botón de Flash Player */
        .flash-badge {
            width: 40px;
            height: 40px;
            background-color: #5c5c5c;
            mask-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg"><path d="M20.5 11H19V7c0-1.1-.9-2-2-2h-4V3.5C13 2.12 11.88 1 10.5 1S8 2.12 8 3.5V5H4c-1.1 0-1.99.9-1.99 2v3.8H3.5c1.49 0 2.7 1.21 2.7 2.7s-1.21 2.7-2.7 2.7H2V20c0 1.1.9 2 2 2h3.8v-1.5c0-1.49 1.21-2.7 2.7-2.7s2.7 1.21 2.7 2.7V22H17c1.1 0 2-.9 2-2v-4h1.5c1.38 0 2.5-1.12 2.5-2.5S21.88 11 20.5 11z"/></svg>');
            -webkit-mask-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg"><path d="M20.5 11H19V7c0-1.1-.9-2-2-2h-4V3.5C13 2.12 11.88 1 10.5 1S8 2.12 8 3.5V5H4c-1.1 0-1.99.9-1.99 2v3.8H3.5c1.49 0 2.7 1.21 2.7 2.7s-1.21 2.7-2.7 2.7H2V20c0 1.1.9 2 2 2h3.8v-1.5c0-1.49 1.21-2.7 2.7-2.7s2.7 1.21 2.7 2.7V22H17c1.1 0 2-.9 2-2v-4h1.5c1.38 0 2.5-1.12 2.5-2.5S21.88 11 20.5 11z"/></svg>');
            background-size: cover;
        }

        .btn-game-primary {
            background-color: #5b74a8;
            color: white;
            font-weight: bold;
            padding: 4px 8px;
            border: 1px solid #29447e;
            font-size: 11px;
            cursor: pointer;
        }
        .btn-game-send {
            background-color: #42b72a;
            color: white;
            font-weight: bold;
            padding: 4px 8px;
            border: 1px solid #3b6e22;
            font-size: 11px;
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

    <div class="pt-14 flex justify-center gap-4 max-w-[1200px] mx-auto px-2">
        
        <div class="hidden lg:block w-[180px] text-[#141823]">
            <h3 class="text-[#9197a3] uppercase font-bold text-[10px] mb-2 px-1">Tus Juegos</h3>
            <ul class="space-y-1 mb-4">
                <li class="flex items-center gap-2 p-1.5 bg-[#eff1f3] font-bold rounded-[2px] cursor-pointer">
                    <img src="https://picsum.photos/20?random=1" class="w-4 h-4 rounded-[2px]">
                    LaraVille
                </li>
                <li class="flex items-center gap-2 p-1.5 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <img src="https://picsum.photos/20?random=2" class="w-4 h-4 rounded-[2px]">
                    PHP Saga
                </li>
                <li class="flex items-center gap-2 p-1.5 hover:bg-[#eff1f3] cursor-pointer rounded-[2px]">
                    <img src="https://picsum.photos/20?random=3" class="w-4 h-4 rounded-[2px]">
                    Code Ninja
                </li>
            </ul>
            
            <h3 class="text-[#9197a3] uppercase font-bold text-[10px] mb-2 px-1">Actividad</h3>
            <div class="text-[11px] text-gray-500 px-1">
                <span class="fb-link">Juan</span> te envió una vaca en <span class="fb-link">LaraVille</span>.
            </div>
        </div>

        <div class="canvas-container">
            
            <div class="app-header">
                <div class="flex items-center gap-2">
                    <img src="https://picsum.photos/32?random=1" class="w-8 h-8 rounded-[3px] border border-gray-300">
                    <div>
                        <h1 class="text-[14px] font-bold text-[#333] hover:underline cursor-pointer">LaraVille</h1>
                        <p class="text-[10px] text-gray-500">Zynga de Laravel Inc.</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="btn-game-send">🎁 Enviar regalo gratis</button>
                    <button class="btn-game-primary">👍 Me gusta</button>
                    <button class="btn-game-primary">Invitar amigos</button>
                </div>
            </div>

            <div class="game-iframe-placeholder group cursor-pointer hover:bg-[#e0e0e0]">
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-500 mx-auto mb-2 relative">
                        <div class="absolute top-0 left-4 w-8 h-4 bg-[#f1f1f1] rounded-full -mt-2"></div>
                        <div class="absolute bottom-0 left-4 w-8 h-4 bg-gray-500 rounded-full -mb-2"></div>
                        <div class="absolute left-0 top-4 h-8 w-4 bg-[#f1f1f1] rounded-full -ml-2"></div>
                        <div class="absolute right-0 top-4 h-8 w-4 bg-gray-500 rounded-full -mr-2"></div>
                    </div>
                    
                    <h2 class="text-[#333] font-bold text-[14px] mb-1">Adobe Flash Player está bloqueado</h2>
                    <p class="text-[#666] text-[12px] mb-4">Se requiere una versión actualizada de Flash para jugar LaraVille.</p>
                    
                    <button class="bg-[#dcdcdc] border border-[#bcbcbc] text-[#333] font-bold px-3 py-1.5 rounded-[2px] text-[11px] hover:bg-[#cfcfcf]">
                        Habilitar Flash Player
                    </button>
                </div>

                <div class="absolute top-2 right-2 bg-white border border-gray-400 p-2 shadow-lg rounded hidden group-hover:block w-60">
                    <div class="text-[11px]">
                        <strong>Plugin bloqueado</strong><br>
                        Chrome ha bloqueado este plugin porque es obsoleto. <span class="text-blue-500 underline">Ejecutar esta vez</span>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-[#bdc7d8] border-t-0 p-3 flex justify-between text-[11px]">
                <div class="flex gap-4 text-[#3b5998] font-bold">
                    <span class="cursor-pointer hover:underline">Preguntas frecuentes</span>
                    <span class="cursor-pointer hover:underline">Reportar problema</span>
                    <span class="cursor-pointer hover:underline">Foro</span>
                </div>
                <div class="text-gray-500">ID de usuario: {{ auth()->id() }}</div>
            </div>

            <div class="mt-4 bg-[#f6f7f9] p-3 border border-[#d3d6db]">
                <h3 class="font-bold border-b border-[#e9eaed] pb-2 mb-2">Comentarios (10,392)</h3>
                <div class="flex gap-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-8 h-8 square">
                    <textarea class="w-full h-8 border border-[#bdc7d8] resize-none p-1 text-sm" placeholder="Añade un comentario..."></textarea>
                </div>
            </div>

        </div>

        <div class="hidden xl:block w-[240px]">
            <div class="bg-white border border-[#bdc7d8] p-2 mb-3">
                <h4 class="text-[#9197a3] uppercase font-bold text-[10px] mb-2">Juegos recomendados</h4>
                <div class="flex gap-2 mb-2">
                    <div class="w-16 h-16 bg-gray-300"></div>
                    <div>
                        <div class="fb-link font-bold">Candy Crush</div>
                        <div class="text-xs text-gray-500">Jugar ahora</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>