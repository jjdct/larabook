<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a Larabook: inicia sesión, regístrate o más</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* La fuente sagrada del 2012 */
        body { 
            background: linear-gradient(white, #D3D8E8); 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; 
        }
        .fb-dark-blue { background-color: #3b5998; }
        .fb-button-blue { background-color: #4267b2; border: 1px solid #29487d; }
        .fb-green-btn { 
            background: linear-gradient(#67ae55, #578843); 
            background-color: #69a74e; 
            box-shadow: inset 0 1px 1px #a4e388; 
            border: 1px solid #3b6e22;
        }
        .fb-input-text { 
            border: 1px solid #1d2a5b; 
            margin: 0; 
            padding: 3px; 
        }
    </style>
</head>
<body class="min-h-screen">

    <div class="fb-dark-blue h-auto md:h-[82px] w-full border-b border-[#133783] shadow-sm">
        <div class="max-w-[980px] mx-auto px-4 h-full flex flex-col md:flex-row items-center justify-between py-2 md:py-0">
            
            <h1 class="text-white text-4xl font-bold tracking-tighter cursor-pointer mt-2 md:mt-0">
                larabook
            </h1>

            @auth
                <div class="flex items-center gap-4">
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 text-white font-bold hover:underline">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-8 h-8 rounded-sm border border-black">
                        {{ Auth::user()->name }}
                    </a>
                    <a href="{{ url('/dashboard') }}" class="bg-white text-[#3b5998] px-3 py-1 font-bold text-sm rounded-sm">Ir al Inicio</a>
                </div>
            @else
                <form method="POST" action="{{ route('login') }}" class="flex flex-col md:flex-row gap-2 md:gap-4 items-center md:items-end mt-2 md:mt-0">
                    @csrf
                    
                    <div>
                        <label class="text-white text-[11px] block mb-1">Correo electrónico o teléfono</label>
                        <input type="email" name="email" class="border border-black text-sm px-1 py-1 w-40" required autofocus>
                        <div class="flex items-center gap-1 mt-1">
                             <input type="checkbox" class="w-3 h-3"> <span class="text-[#98a9ca] text-[11px]">No cerrar sesión</span>
                        </div>
                    </div>

                    <div>
                        <label class="text-white text-[11px] block mb-1">Contraseña</label>
                        <input type="password" name="password" class="border border-black text-sm px-1 py-1 w-40" required>
                        <a href="{{ route('password.request') }}" class="text-[#98a9ca] text-[11px] block mt-1 hover:underline">¿Olvidaste tu cuenta?</a>
                    </div>

                    <button type="submit" class="bg-[#4267b2] text-white font-bold text-xs px-3 py-1.5 border border-[#29487d] mb-5 md:mb-0 shadow-sm hover:bg-[#365899]">
                        Entrar
                    </button>
                </form>
            @endauth
        </div>
    </div>

    <div class="max-w-[980px] mx-auto px-4 pt-10 flex flex-col md:flex-row gap-10">
        
        <div class="md:w-3/5 text-center md:text-left">
            <h2 class="text-[#0e385f] text-[28px] font-bold w-full md:w-3/4 leading-tight mb-6">
                Larabook te ayuda a comunicarte y compartir con las personas que forman parte de tu vida.
            </h2>
            <img src="{{ asset('images/world.png') }}" class="w-full md:w-[500px] mx-auto opacity-90">
        </div>

        <div class="md:w-2/5">
            <h2 class="text-[#333] text-4xl font-bold mb-2">Crear cuenta nueva</h2>
            <p class="text-[#1d2129] text-lg mb-6">Es rápido y fácil.</p>

            <div class="space-y-4">
                <div class="flex gap-2">
                    <input type="text" placeholder="Nombre" class="w-1/2 p-2 border border-[#bdc7d8] rounded-[5px] text-lg bg-[#f5f6f7]" disabled>
                    <input type="text" placeholder="Apellidos" class="w-1/2 p-2 border border-[#bdc7d8] rounded-[5px] text-lg bg-[#f5f6f7]" disabled>
                </div>
                <input type="text" placeholder="Número de móvil o correo electrónico" class="w-full p-2 border border-[#bdc7d8] rounded-[5px] text-lg bg-[#f5f6f7]" disabled>
                <input type="password" placeholder="Contraseña nueva" class="w-full p-2 border border-[#bdc7d8] rounded-[5px] text-lg bg-[#f5f6f7]" disabled>
                
                <p class="text-[11px] text-[#777]">
                    Al hacer clic en "Registrarte", aceptas nuestras Condiciones.
                </p>

                <div class="text-center md:text-left">
                    <a href="{{ route('register') }}" class="inline-block fb-green-btn text-white font-bold text-xl px-10 py-2 rounded-[5px] shadow-md hover:brightness-110">
                        Registrarte
                    </a>
                </div>
                
                <div class="mt-6 border-t border-[#ddd] pt-4">
                     <p class="text-[13px] font-bold text-[#3b5998] cursor-pointer hover:underline">Crea una página</p> 
                     <span class="text-[13px] text-[#666]"> para un grupo de música, un famoso o un negocio.</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="max-w-[980px] mx-auto px-4 mt-20 border-t border-[#ddd] pt-4 text-[11px] text-[#737373]">
        <div class="flex flex-wrap gap-4 mb-2">
            <span>Español</span>
            <span class="text-[#365899] cursor-pointer hover:underline">English (US)</span>
            <span class="text-[#365899] cursor-pointer hover:underline">Français (France)</span>
        </div>
        <div class="border-t border-[#ddd] pt-2">
            Larabook © 2026
        </div>
    </div>

</body>
</html>