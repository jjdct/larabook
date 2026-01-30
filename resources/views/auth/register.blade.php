<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Regístrate en Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-color: #e9ebee; 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
        }
        .fb-header { background-color: #3b5998; height: 82px; border-bottom: 1px solid #133783; }
        .fb-btn-login {
            background-color: #4267b2;
            border: 1px solid #29487d;
            color: white;
            font-weight: bold;
            font-size: 12px;
            padding: 4px 10px;
            cursor: pointer;
        }
        .fb-box {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
        }
        .input-text {
            border: 1px solid #bdc7d8;
            padding: 8px 10px;
            font-size: 18px;
            border-radius: 5px;
            width: 100%;
        }
        .fb-green-btn {
            background: linear-gradient(#67ae55, #578843);
            background-color: #69a74e;
            box-shadow: inset 0 1px 1px #a4e388;
            border: 1px solid #3b6e22;
            text-shadow: 0 1px 2px rgba(0,0,0,.5);
            cursor: pointer;
        }
        .fb-green-btn:hover { background: linear-gradient(#79bc64, #578843); }
    </style>
</head>
<body>

    <div class="fb-header w-full mb-8">
        <div class="max-w-[980px] mx-auto px-4 h-full flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-white text-4xl font-bold tracking-tighter cursor-pointer hover:no-underline decoration-none">
                larabook
            </a>
            
            <form method="POST" action="{{ route('login') }}" class="flex items-center gap-2">
                @csrf
                <div class="flex flex-col">
                    <label class="text-white text-[11px] font-normal">Correo electrónico</label>
                    <input type="email" name="email" class="border border-black text-xs px-1 py-0.5 w-32">
                </div>
                <div class="flex flex-col">
                    <label class="text-white text-[11px] font-normal">Contraseña</label>
                    <input type="password" name="password" class="border border-black text-xs px-1 py-0.5 w-32">
                </div>
                <button type="submit" class="fb-btn-login mt-4">Entrar</button>
            </form>
        </div>
    </div>

    <div class="max-w-[980px] mx-auto px-4 flex justify-center">
        
        <div class="w-full max-w-[600px]">
            <h2 class="text-[#333] text-4xl font-bold mb-2">Crear cuenta nueva</h2>
            <p class="text-[#1d2129] text-lg mb-6">Es gratis y lo será siempre.</p>

            <div class="fb-box">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="flex gap-3 mb-4">
                        <div class="w-1/2">
                            <input type="text" name="first_name" placeholder="Nombre" class="input-text" required value="{{ old('first_name') }}">
                            @error('first_name') <span class="text-red-600 text-xs block mt-1">⚠️ {{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <input type="text" name="last_name" placeholder="Apellidos" class="input-text" required value="{{ old('last_name') }}">
                            @error('last_name') <span class="text-red-600 text-xs block mt-1">⚠️ {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <input type="email" name="email" placeholder="Número de móvil o correo electrónico" class="input-text" required value="{{ old('email') }}">
                        @error('email') <span class="text-red-600 text-xs block mt-1">⚠️ {{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <input type="password" name="password" placeholder="Contraseña nueva" class="input-text" required>
                        @error('password') <span class="text-red-600 text-xs block mt-1">⚠️ {{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="input-text" required>
                    </div>

                    <div class="mb-4">
                        <label class="text-[#141823] font-bold text-sm block mb-1">Fecha de nacimiento</label>
                        <div class="flex gap-2">
                            <select name="day" class="border p-1 text-sm h-[30px]">
                                <option value="">Día</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>

                            <select name="month" class="border p-1 text-sm h-[30px]">
                                <option value="">Mes</option>
                                @foreach(['01'=>'Ene', '02'=>'Feb', '03'=>'Mar', '04'=>'Abr', '05'=>'May', '06'=>'Jun', '07'=>'Jul', '08'=>'Ago', '09'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dic'] as $key => $mes)
                                    <option value="{{ $key }}">{{ $mes }}</option>
                                @endforeach
                            </select>

                            <select name="year" class="border p-1 text-sm h-[30px]">
                                <option value="">Año</option>
                                @for ($i = date('Y'); $i >= 1905; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            
                            <a href="#" class="text-[11px] text-[#3b5998] hover:underline ml-2 flex items-center">¿Por qué tengo que dar mi fecha de nacimiento?</a>
                        </div>
                        @if($errors->has('day') || $errors->has('month') || $errors->has('year'))
                            <span class="text-red-600 text-xs block mt-1">⚠️ Selecciona una fecha válida.</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1 text-[#1d2129] font-bold text-sm cursor-pointer">
                                <input type="radio" name="gender" value="female"> Mujer
                            </label>
                            <label class="flex items-center gap-1 text-[#1d2129] font-bold text-sm cursor-pointer">
                                <input type="radio" name="gender" value="male"> Hombre
                            </label>
                        </div>
                        @error('gender') <span class="text-red-600 text-xs block mt-1">⚠️ Selecciona tu sexo.</span> @enderror
                    </div>

                    <p class="text-[11px] text-[#777] mb-6 w-3/4">
                        Al hacer clic en "Registrarte", aceptas nuestras Condiciones, la Política de datos y la Política de cookies.
                    </p>

                    <button type="submit" class="fb-green-btn text-white font-bold text-xl px-12 py-2 rounded-[5px]">
                        Registrarte
                    </button>
                </form>
            </div>
        </div>
    </div>

    <br><br>

</body>
</html>