<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-color: #e9ebee; 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
        }
        .fb-header { background-color: #3b5998; height: 82px; border-bottom: 1px solid #133783; }
        .fb-box { 
            background-color: #fff; 
            border: 1px solid #ccc; 
            border-radius: 3px;
        }
        .fb-btn-login {
            background-color: #4267b2;
            border: 1px solid #29487d;
            color: white;
            font-weight: bold;
            font-size: 13px;
            padding: 5px 10px;
            cursor: pointer;
        }
        .fb-btn-login:hover { background-color: #365899; }
        
        .fb-btn-signup {
            background-color: #42b72a;
            border: 1px solid #2c8415;
            color: white;
            font-weight: bold;
            font-size: 13px;
            padding: 5px 10px;
            border-radius: 2px;
        }
        .input-text {
            border: 1px solid #bdc7d8;
            padding: 8px;
            width: 100%;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="fb-header w-full mb-10">
        <div class="max-w-[980px] mx-auto px-4 h-full flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-white text-4xl font-bold tracking-tighter cursor-pointer hover:no-underline decoration-none">
                larabook
            </a>
            
            <a href="{{ route('register') }}" class="fb-btn-signup shadow-sm">
                Registrarte
            </a>
        </div>
    </div>

    <div class="max-w-[400px] mx-auto">
        <div class="fb-box p-0 shadow-sm">
            
            <div class="border-b border-[#ddd] px-4 py-3 bg-white rounded-t-[3px]">
                <h2 class="text-[#141823] font-bold text-[16px]">Iniciar sesión en Larabook</h2>
            </div>

            <div class="p-6 pt-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-4 border border-[#dd3c10] bg-[#ffebe8] p-3 text-[13px]">
                            <p class="font-bold text-[#333]">Datos incorrectos</p>
                            <p class="text-[#333]">El correo electrónico o la contraseña que has introducido no coinciden.</p>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-[#666] text-xs font-bold mb-1">Correo electrónico o teléfono:</label>
                        <input type="email" name="email" class="input-text rounded-none focus:outline-none focus:border-[#899bc1]" autofocus required value="{{ old('email') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-[#666] text-xs font-bold mb-1">Contraseña:</label>
                        <input type="password" name="password" class="input-text rounded-none focus:outline-none focus:border-[#899bc1]" required>
                    </div>

                    <div class="flex items-center gap-2 mb-6">
                        <input type="checkbox" id="remember" name="remember" class="border border-[#ccc]">
                        <label for="remember" class="text-[13px] text-[#141823]">No cerrar sesión</label>
                    </div>

                    <div class="flex items-center justify-between mt-2">
                        <button type="submit" class="fb-btn-login px-6 py-1.5 shadow-sm">
                            Iniciar sesión
                        </button>
                        
                        <a href="{{ route('password.request') }}" class="text-[#3b5998] text-[12px] hover:underline cursor-pointer">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-[980px] mx-auto text-center mt-10 text-[11px] text-[#737373]">
        Larabook © 2026 · <span class="text-[#3b5998] hover:underline cursor-pointer">Español</span>
    </div>

</body>
</html>