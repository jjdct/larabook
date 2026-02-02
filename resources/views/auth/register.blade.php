<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate en Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif; color: #1c1e21; }
        
        /* Header */
        .fb-header { background-color: #3b5998; background-image: linear-gradient(#4e69a2, #3b5998 50%); border-bottom: 1px solid #133783; }
        .header-input { border: 1px solid #1d4085; padding: 2px 3px; color: black; font-size: 12px; height: 24px; }
        .header-btn { background-color: #4267b2; border: 1px solid #29487d; color: white; font-weight: bold; cursor: pointer; height: 24px; line-height: 22px; padding: 0 10px; }
        .header-btn:hover { background-color: #365899; }

        /* Formulario Principal */
        .fb-input { border: 1px solid #bdc7d8; padding: 8px 10px; font-size: 18px; border-radius: 5px; color: #1c1e21; width: 100%; }
        
        /* Botón Verde (Estilo 2018) */
        .fb-green-btn { 
            background-color: #42b72a; 
            border: 1px solid #42b72a; 
            border-radius: 5px;
            font-weight: bold;
            color: white;
            transition: 0.2s;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        .fb-green-btn:hover { background-color: #36a420; border-color: #36a420; }
        
        /* Tooltip de ayuda */
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
<body class="flex flex-col min-h-screen">

    <div class="fb-header h-[82px] flex items-center justify-center w-full min-w-[980px]">
        <div class="w-[980px] px-4 md:px-0 flex justify-between items-center h-full">
            <a href="/" class="text-white text-[40px] font-bold tracking-tighter no-underline hover:no-underline mt-3">larabook</a>
            
            <form method="POST" action="{{ route('login') }}" class="flex gap-3 items-start mt-3">
                @csrf
                <div>
                    <label class="text-white text-[11px] block mb-1 font-normal leading-3">Correo electrónico</label>
                    <input type="email" name="email" class="header-input w-[150px]">
                    <div class="flex items-center gap-1 mt-1">
                        <input type="checkbox" name="remember" id="persist_box" class="w-3 h-3 border-[#1d4085] rounded-none p-0 m-0"> 
                        <label for="persist_box" class="text-[#98a9ca] text-[12px] cursor-pointer hover:underline font-normal leading-3">No cerrar sesión</label>
                   </div>
                </div>
                <div>
                    <label class="text-white text-[11px] block mb-1 font-normal leading-3">Contraseña</label>
                    <input type="password" name="password" class="header-input w-[150px]">
                    <a href="{{ route('password.request') }}" class="text-[#9cb4d8] text-[11px] block hover:underline mt-1 font-normal leading-3">¿Olvidaste tu cuenta?</a>
                </div>
                <button type="submit" class="header-btn mt-[17px] text-[12px]">Entrar</button>
            </form>
        </div>
    </div>

    <div class="flex-grow pt-12 pb-20">
        <div class="w-[500px] mx-auto"> 
            
            <h1 class="text-[36px] font-bold text-[#333] mb-1 leading-tight text-center">Crea una cuenta nueva</h1>
            <p class="text-[19px] text-[#1c1e21] mb-6 text-center">Es gratis y lo será siempre.</p>

            <div class="bg-white p-0 md:p-5 rounded md:bg-transparent relative">
                <form method="POST" action="{{ route('register') }}" onsubmit="return prepareForm()" class="space-y-3">
                    @csrf

                    <div class="flex gap-3">
                        <div class="w-1/2">
                            <input type="text" name="first_name" placeholder="Nombre" class="fb-input" required value="{{ old('first_name') }}">
                            @error('first_name') <p class="text-[11px] text-[#dd3c10] mt-1">⚠️ {{ $message }}</p> @enderror
                        </div>
                        <div class="w-1/2">
                            <input type="text" name="last_name" placeholder="Apellido" class="fb-input" required value="{{ old('last_name') }}">
                             @error('last_name') <p class="text-[11px] text-[#dd3c10] mt-1">⚠️ {{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <input type="email" name="email" placeholder="Número de móvil o correo electrónico" class="fb-input" required value="{{ old('email') }}">
                         @error('email') <p class="text-[11px] text-[#dd3c10] mt-1">⚠️ {{ $message }}</p> @enderror
                    </div>

                    <div>
                        <input type="password" name="password" placeholder="Contraseña nueva" class="fb-input" required>
                         @error('password') <p class="text-[11px] text-[#dd3c10] mt-1">⚠️ {{ $message }}</p> @enderror
                    </div>
                    <div>
                         <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="fb-input" required>
                    </div>

                    <div class="mt-4 relative">
                        <label class="text-[#90949c] font-bold text-[16px] block mb-1">Fecha de nacimiento</label>
                        <div class="flex gap-1 items-center">
                            <select id="day" class="border border-[#bdc7d8] p-1 h-[30px]"><option value="0">Día</option>@for($i=1;$i<=31;$i++)<option value="{{$i}}">{{$i}}</option>@endfor</select>
                            <select id="month" class="border border-[#bdc7d8] p-1 h-[30px]"><option value="0">Mes</option>@foreach(['01'=>'ene','02'=>'feb','03'=>'mar','04'=>'abr','05'=>'may','06'=>'jun','07'=>'jul','08'=>'ago','09'=>'sep','10'=>'oct','11'=>'nov','12'=>'dic'] as $k=>$v)<option value="{{$k}}">{{$v}}</option>@endforeach</select>
                            <select id="year" class="border border-[#bdc7d8] p-1 h-[30px]"><option value="0">Año</option>@for($i=date('Y');$i>=1905;$i--)<option value="{{$i}}">{{$i}}</option>@endfor</select>
                            
                            <a href="#" onclick="toggleBirthdayHelp(event)" class="text-[#365899] text-[11px] hover:underline ml-3 font-normal">
                                ¿Por qué tengo que dar mi fecha de nacimiento?
                            </a>
                        </div>
                        
                        <div id="birthday_help_box" class="birthday-tooltip">
                            <div class="arrow-left"></div>
                            <strong>Fecha de nacimiento</strong>
                            <p class="mt-1">Proporcionar tu fecha de nacimiento ayuda a asegurar que obtengas la experiencia adecuada de Larabook para tu edad. Si quieres, puedes cambiar quién ve esto en tu biografía más tarde.</p>
                        </div>

                        <input type="hidden" name="birthday" id="birthday_input">
                        @error('birthday') <p class="text-[11px] text-[#dd3c10] mt-1">⚠️ Selecciona una fecha válida.</p> @enderror
                    </div>

                    <div class="mt-3">
                        <label class="text-[#90949c] font-bold text-[16px] block mb-1">Sexo</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1 cursor-pointer font-normal text-[18px]">
                                <input type="radio" name="gender" value="female" required onclick="toggleCustom(false)"> Mujer
                            </label>
                            <label class="flex items-center gap-1 cursor-pointer font-normal text-[18px]">
                                <input type="radio" name="gender" value="male" required onclick="toggleCustom(false)"> Hombre
                            </label>
                            <label class="flex items-center gap-1 cursor-pointer font-normal text-[18px]">
                                <input type="radio" name="gender" value="custom" required onclick="toggleCustom(true)"> Personalizado
                            </label>
                        </div>
                        
                        <div id="custom_gender_box" class="hidden p-3 bg-[#f5f6f7] border border-[#dddfe2] rounded mt-2 space-y-2 relative">
                            <div class="absolute -top-1.5 left-[160px] w-3 h-3 bg-[#f5f6f7] border-t border-l border-[#dddfe2] transform rotate-45"></div>
                            <select name="pronoun" class="w-full p-2 border border-[#bdc7d8] text-sm rounded h-[35px]">
                                <option value="" disabled selected>Selecciona tu pronombre</option>
                                <option value="she">Ella: "Deséale un feliz cumpleaños a ella"</option>
                                <option value="he">Él: "Deséale un feliz cumpleaños a él"</option>
                                <option value="they">Neutro: "Deséales un feliz cumpleaños a ell@s"</option>
                            </select>
                            <div class="text-[11px] text-[#606770] mb-1">Tu pronombre es visible para todos.</div>
                            <input type="text" name="custom_gender_string" placeholder="Sexo (opcional)" class="w-full p-2 border border-[#bdc7d8] text-sm rounded h-[30px]">
                        </div>
                        @error('gender') <p class="text-[11px] text-[#dd3c10] mt-1">⚠️ {{ $message }}</p> @enderror
                    </div>

                    <p class="text-[11px] text-[#777] mt-4 mb-4 leading-snug text-center mx-auto w-[400px]">
                        Al hacer clic en "Registrarte", aceptas nuestras <a href="#" class="text-[#385898] hover:underline">Condiciones</a>, la <a href="#" class="text-[#385898] hover:underline">Política de datos</a> y la <a href="#" class="text-[#385898] hover:underline">Política de cookies</a>.
                    </p>

                    <div class="text-center">
                        <button type="submit" class="fb-green-btn text-white font-bold text-[18px] px-[32px] py-[7px] min-w-[194px] cursor-pointer tracking-wide shadow-md">
                            Registrarte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-white pt-5 pb-5 w-full mt-auto border-t border-[#dddfe2]">
        <div class="w-[980px] mx-auto text-[#737373] text-[12px]">
            <div class="flex flex-wrap gap-2 mb-2">
                <span>Español</span><a href="#" class="text-[#385898] hover:underline">English (US)</a><a href="#" class="text-[#385898] hover:underline">Français (France)</a>
            </div>
            <div class="border-t border-[#ddd] my-2"></div>
            <div class="mb-4"> Larabook © 2026 </div>
        </div>
    </footer>

    <script>
        // 1. Tooltip Ayuda Cumpleaños
        function toggleBirthdayHelp(e) {
            e.preventDefault();
            const box = document.getElementById('birthday_help_box');
            if (box.style.display === 'block') { box.style.display = 'none'; } 
            else { box.style.display = 'block'; }
        }

        // 2. Toggle Género Personalizado
        function toggleCustom(show) {
            const box = document.getElementById('custom_gender_box');
            if(show) { box.classList.remove('hidden'); } else { box.classList.add('hidden'); }
        }

        // 3. Preparar Fecha
        function prepareForm() {
            const d = document.getElementById('day').value;
            const m = document.getElementById('month').value;
            const y = document.getElementById('year').value;
            if(d!=0 && m!=0 && y!=0) {
                const dStr = d.toString().padStart(2, '0');
                const mStr = m.toString().padStart(2, '0');
                document.getElementById('birthday_input').value = `${y}-${mStr}-${dStr}`;
            } else {
                document.getElementById('birthday_input').value = '';
            }
            return true;
        }
    </script>
</body>
</html>