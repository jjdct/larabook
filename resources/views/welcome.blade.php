<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Larabook - Inicia sesión o regístrate</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { 
            background-color: #e9ebee; 
            font-family: Helvetica, Arial, sans-serif;
            color: #1d2129;
        }
        
        /* Header */
        .fb-header { background-color: #3b5998; background-image: linear-gradient(#4e69a2, #3b5998 50%); border-bottom: 1px solid #133783; }
        .fb-login-btn { background-color: #4267b2; border: 1px solid #29487d; font-weight: bold; cursor: pointer; }
        .fb-login-btn:hover { background-color: #365899; }

        /* Botón Verde (Plano 2018) */
        .fb-green-btn { 
            background-color: #42b72a; 
            border: 1px solid #42b72a; 
            border-radius: 5px;
            text-shadow: none; 
            font-weight: bold;
            color: white;
            transition: 200ms;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .fb-green-btn:hover { background-color: #36a420; }

        /* Inputs */
        .fb-input { 
            border: 1px solid #bdc7d8; 
            padding: 8px 10px;
            font-size: 18px;
            border-radius: 5px;
            color: #1c1e21;
        }
        
        /* Input pequeño del header */
        .header-input { border: 1px solid #1d4085; color: black; padding: 3px; }

        /* Tooltip de Cumpleaños */
        .birthday-tooltip {
            display: none;
            position: absolute;
            background: white;
            border: 1px solid #bdc7d8;
            padding: 10px;
            font-size: 11px;
            width: 300px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 50;
            line-height: 1.4;
            color: #4b4f56;
            left: 300px;
            top: 35px;
        }
        .arrow-left {
            position: absolute;
            top: 10px;
            left: -6px;
            width: 10px;
            height: 10px;
            background: white;
            border-left: 1px solid #bdc7d8;
            border-bottom: 1px solid #bdc7d8;
            transform: rotate(45deg);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <div class="fb-header w-full h-auto md:h-[82px] py-2 md:py-0 relative z-20">
        <div class="max-w-[980px] mx-auto px-2 md:px-0 h-full flex flex-col md:flex-row items-center justify-between">
            
            <h1 class="text-white text-[40px] font-bold tracking-tighter cursor-pointer mt-2 md:mt-4 select-none self-start md:self-center">
                <a href="/" class="no-underline text-white hover:no-underline">larabook</a>
            </h1>

            @auth
                <div class="flex items-center gap-4 mt-2 md:mt-4 self-end md:self-center">
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 text-white font-bold text-sm hover:underline">
                        <img src="{{ Auth::user()->avatar }}" class="w-6 h-6 rounded-full border border-white bg-white">
                        {{ Auth::user()->first_name }}
                    </a>
                </div>
            @else
                <form method="POST" action="{{ route('login') }}" class="flex gap-3.5 items-start mt-3 md:mt-3 self-end md:self-center">
                    @csrf
                    
                    <div>
                        <label class="text-white text-[12px] block mb-1 font-normal leading-3">Correo electrónico o teléfono</label>
                        <input type="email" name="email" class="header-input text-xs w-[150px]" required>
                        
                        <div class="flex items-center gap-1 mt-1">
                             <input type="checkbox" name="remember" id="persist_box" class="w-3 h-3 border-[#1d4085] rounded-none"> 
                             <label for="persist_box" class="text-[#98a9ca] text-[12px] cursor-pointer hover:underline font-normal">No cerrar sesión</label>
                        </div>
                    </div>

                    <div>
                        <label class="text-white text-[12px] block mb-1 font-normal leading-3">Contraseña</label>
                        <input type="password" name="password" class="header-input text-xs w-[150px]" required>
                        <a href="{{ route('password.request') }}" class="text-[#98a9ca] text-[12px] block mt-1 hover:underline font-normal">¿Olvidaste tu cuenta?</a>
                    </div>

                    <button type="submit" class="fb-login-btn text-white text-[12px] font-bold px-2.5 py-[3px] mt-[18px] shadow-sm">
                        Entrar
                    </button>
                </form>
            @endauth
        </div>
    </div>

    <div class="flex-grow">
        <div class="max-w-[980px] mx-auto pt-8 flex flex-col md:flex-row gap-5 md:justify-between">
            
            <div class="md:w-[580px] pt-4 hidden md:block">
                <h2 class="text-[#0e385f] text-[20px] font-bold w-[90%] leading-[29px] mb-5">
                    Larabook te ayuda a comunicarte y compartir con las personas que forman parte de tu vida.
                </h2>
                <img src="{{ asset('images/world.png') }}" class="w-full max-w-[537px]">
            </div>

            <div class="md:w-[396px]">
                <h2 class="text-[#333] text-[36px] font-bold mb-0 leading-tight">Abre una cuenta</h2>
                <p class="text-[#1d2129] text-[19px] mb-4">Es gratis y lo será siempre.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-2.5" onsubmit="return prepareBirthday()">
                    @csrf

                    <div class="flex gap-2.5">
                        <div class="w-1/2">
                            <input type="text" name="first_name" placeholder="Nombre" class="fb-input w-full" required value="{{ old('first_name') }}">
                            @error('first_name') <div class="text-[#dd3c10] text-[11px] mt-1">⚠️ {{ $message }}</div> @enderror
                        </div>
                        <div class="w-1/2">
                            <input type="text" name="last_name" placeholder="Apellido" class="fb-input w-full" required value="{{ old('last_name') }}">
                            @error('last_name') <div class="text-[#dd3c10] text-[11px] mt-1">⚠️ {{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <input type="email" name="email" placeholder="Número de móvil o correo electrónico" class="fb-input w-full" required value="{{ old('email') }}">
                        @error('email') <div class="text-[#dd3c10] text-[11px] mt-1">⚠️ {{ $message }}</div> @enderror
                    </div>

                    <div>
                        <input type="password" name="password" id="reg_password" placeholder="Contraseña nueva" class="fb-input w-full" required>
                        @error('password') <div class="text-[#dd3c10] text-[11px] mt-1">⚠️ {{ $message }}</div> @enderror
                    </div>
                    <div id="confirm_box" class="hidden">
                        <input type="password" name="password_confirmation" id="reg_password_confirmation" class="fb-input w-full mt-2">
                    </div>
                    
                    <div class="mt-4 relative">
                        <label class="text-[#90949c] font-bold text-[16px] block mb-1">Fecha de nacimiento</label>
                        <div class="flex gap-1 items-center">
                            <select id="day" class="border border-[#bdc7d8] p-1 text-xs h-[30px] w-auto text-[#1c1e21] rounded-none bg-white"><option value="0">Día</option>@for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}">{{ $i }}</option> @endfor</select>
                            <select id="month" class="border border-[#bdc7d8] p-1 text-xs h-[30px] w-auto text-[#1c1e21] rounded-none bg-white"><option value="0">Mes</option>@foreach(['01'=>'ene', '02'=>'feb', '03'=>'mar', '04'=>'abr', '05'=>'may', '06'=>'jun', '07'=>'jul', '08'=>'ago', '09'=>'sep', '10'=>'oct', '11'=>'nov', '12'=>'dic'] as $key => $mes)<option value="{{ $key }}">{{ $mes }}</option>@endforeach</select>
                            <select id="year" class="border border-[#bdc7d8] p-1 text-xs h-[30px] w-auto text-[#1c1e21] rounded-none bg-white"><option value="0">Año</option>@for ($i = date('Y'); $i >= 1905; $i--) <option value="{{ $i }}">{{ $i }}</option> @endfor</select>
                            
                            <a href="#" onclick="toggleBirthdayHelp(event)" class="text-[#365899] text-[11px] hover:underline ml-2 flex items-center max-w-[150px] leading-3">
                                ¿Por qué tengo que dar mi fecha de nacimiento?
                            </a>
                        </div>
                        
                        <div id="birthday_help_box" class="birthday-tooltip">
                            <div class="arrow-left"></div>
                            <strong>Fecha de nacimiento</strong>
                            <p class="mt-1">Proporcionar tu fecha de nacimiento ayuda a asegurar que obtengas la experiencia adecuada de Larabook para tu edad. Si quieres, puedes cambiar quién ve esto en tu biografía más tarde.</p>
                        </div>

                        <input type="hidden" name="birthday" id="birthday_input">
                        @error('birthday') <div class="text-[#dd3c10] text-[11px] mt-1">⚠️ Selecciona una fecha válida.</div> @enderror
                    </div>

                    <div class="mt-3">
                        <label class="text-[#90949c] font-bold text-[16px] block mb-1">Sexo</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1 text-[#1c1e21] font-normal text-[18px] leading-5 cursor-pointer"><input type="radio" name="gender" value="female" required> Mujer</label>
                            <label class="flex items-center gap-1 text-[#1c1e21] font-normal text-[18px] leading-5 cursor-pointer"><input type="radio" name="gender" value="male" required> Hombre</label>
                        </div>
                        @error('gender') <div class="text-[#dd3c10] text-[11px] mt-1">⚠️ {{ $message }}</div> @enderror
                    </div>
                    
                    <p class="text-[11px] text-[#777] mt-3 mb-4 leading-[1.35] w-[300px]">
                        Al hacer clic en "Registrarte", aceptas nuestras <a href="#" class="text-[#385898] hover:underline">Condiciones</a>, la <a href="#" class="text-[#385898] hover:underline">Política de datos</a> y la <a href="#" class="text-[#385898] hover:underline">Política de cookies</a>.
                    </p>

                    <div class="text-left">
                        <button type="submit" class="fb-green-btn text-white font-bold text-[18px] px-[32px] py-[7px] min-w-[194px] cursor-pointer tracking-wide shadow-md">
                            Registrarte
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 border-t border-transparent">
                     <p class="text-[13px] font-bold text-[#666]">
                        <a href="/pages/create" class="text-[#385898] hover:underline">Crea una página</a> para un personaje público, un grupo de música o un negocio.
                     </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white pt-5 pb-5 w-full mt-auto">
        <div class="max-w-[980px] mx-auto px-4 text-[12px] text-[#737373]">
            <div class="flex flex-wrap gap-2.5 mb-2 text-[#737373]">
                <span>Español</span><a href="#" class="text-[#385898] hover:underline">English (US)</a><a href="#" class="text-[#385898] hover:underline">Français (France)</a>
                <a href="#" class="text-[#385898] hover:underline">Português (Brasil)</a><a href="#" class="text-[#385898] hover:underline">Italiano</a><a href="#" class="text-[#385898] hover:underline">Deutsch</a>
            </div>
            <div class="border-t border-[#ddd] my-2"></div>
            <div class="flex flex-wrap gap-x-4 gap-y-1 mb-4 text-[#385898]">
                <a href="#" class="hover:underline">Registrarte</a>
                <a href="#" class="hover:underline">Iniciar sesión</a>
                <a href="#" class="hover:underline">Messenger</a>
                <a href="#" class="hover:underline">Facebook Lite</a>
                <a href="#" class="hover:underline">Móvil</a>
                <a href="#" class="hover:underline">Ayuda</a>
            </div>
            <div class="text-[11px] text-[#737373] mt-4">Larabook © {{ date('Y') }}</div>
        </div>
    </footer>

    <script>
        // 1. ESPEJO DE CONTRASEÑA
        const mainPass = document.getElementById('reg_password');
        const confirmPass = document.getElementById('reg_password_confirmation');
        mainPass.addEventListener('input', function() { confirmPass.value = this.value; });

        // 2. TOOLTIP FECHA
        function toggleBirthdayHelp(e) {
            e.preventDefault();
            const box = document.getElementById('birthday_help_box');
            if (box.style.display === 'block') { box.style.display = 'none'; } 
            else { box.style.display = 'block'; }
        }

        // 3. PREPARAR FECHA
        function prepareBirthday() {
            const d = document.getElementById('day').value;
            const m = document.getElementById('month').value;
            const y = document.getElementById('year').value;
            if (d == 0 || m == 0 || y == 0) {
                document.getElementById('birthday_input').value = '';
                return true; 
            }
            const dStr = d.toString().padStart(2, '0');
            const mStr = m.toString().padStart(2, '0');
            document.getElementById('birthday_input').value = `${y}-${mStr}-${dStr}`;
            return true;
        }
    </script>
</body>
</html>