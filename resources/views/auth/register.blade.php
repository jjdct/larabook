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
            border: 1px solid #ccc; /* Sin bordes redondeados modernos */
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
                            <input type="text" name="name" placeholder="Nombre" class="input-text" required value="{{ old('name') }}">
                            @error('name') <span class="text-red-600 text-xs block mt-1">⚠ {{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <input type="text" placeholder="Apellidos" class="input-text">
                        </div>
                    </div>

                    <div class="mb-4">
                        <input type="email" name="email" placeholder="Número de móvil o correo electrónico" class="input-text" required value="{{ old('email') }}">
                        @error('email') <span class="text-red-600 text-xs block mt-1">⚠ {{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <input type="password" name="password" placeholder="Contraseña nueva" class="input-text" required>
                        @error('password') <span class="text-red-600 text-xs block mt-1">⚠ {{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="input-text" required>
                    </div>

                    <div class="mb-4">
                        <label class="text-[#141823] font-bold text-sm block mb-1">Fecha de nacimiento</label>
                        <div class="flex gap-2">
                            <select class="border p-1 text-sm"><option>Día</option><option>28</option></select>
                            <select class="border p-1 text-sm"><option>Mes</option><option>Ene</option></select>
                            <select class="border p-1 text-sm"><option>Año</option><option>2026</option></select>
                            <a href="#" class="text-[11px] text-[#3b5998] hover:underline ml-2 flex items-center">¿Por qué tengo que dar mi fecha de nacimiento?</a>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex gap-4">
                            <label class="flex items-center gap-1 text-[#1d2129] font-bold text-sm">
                                <input type="radio" name="sex" value="2"> Mujer
                            </label>
                            <label class="flex items-center gap-1 text-[#1d2129] font-bold text-sm">
                                <input type="radio" name="sex" value="1"> Hombre
                            </label>
                        </div>
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