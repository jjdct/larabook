<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar a Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif; color: #1c1e21; }
        
        /* Header */
        .fb-header { background-color: #3b5998; background-image: linear-gradient(#4e69a2, #3b5998 50%); border-bottom: 1px solid #133783; }
        
        /* Inputs */
        .fb-input { 
            border: 1px solid #bdc7d8; 
            padding: 12px 10px; /* Un poco más alto en la login card */
            font-size: 18px; 
            border-radius: 5px; 
            color: #1c1e21; 
            width: 100%; 
        }
        .fb-input:focus { border-color: #1877f2; outline: none; box-shadow: 0 0 0 2px #e7f3ff; }

        /* Botón Verde (Header) */
        .fb-green-btn { 
            background-color: #42b72a; 
            border: 1px solid #42b72a; 
            border-radius: 5px;
            font-weight: bold;
            color: white;
            transition: 0.2s;
            cursor: pointer;
        }
        .fb-green-btn:hover { background-color: #36a420; }

        /* Botón Azul (Login Principal) */
        .fb-blue-btn {
            background-color: #1877f2; /* Azul brillante post-2016 */
            border: none;
            border-radius: 6px;
            font-size: 20px;
            line-height: 48px;
            padding: 0 16px;
            width: 100%;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }
        .fb-blue-btn:hover { background-color: #166fe5; }

        /* Login Card */
        .login-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1), 0 8px 16px rgba(0, 0, 0, .1);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <div class="fb-header h-[82px] flex items-center justify-center w-full min-w-[980px]">
        <div class="w-[980px] px-4 md:px-0 flex justify-between items-center h-full">
            <a href="/" class="text-white text-[40px] font-bold tracking-tighter no-underline hover:no-underline mt-3">larabook</a>
            
            <a href="{{ route('register') }}" class="fb-green-btn text-[14px] px-4 py-1.5 mt-2 no-underline hover:no-underline">
                Crear cuenta nueva
            </a>
        </div>
    </div>

    <div class="flex-grow flex items-center justify-center py-10">
        <div class="login-card w-[396px] p-4 pt-5 pb-6 text-center">
            
            <h3 class="text-[#1c1e21] text-[18px] font-normal mb-4 leading-6">
                Iniciar sesión en Larabook
            </h3>

            <form method="POST" action="{{ route('login') }}" class="space-y-3">
                @csrf

                <div>
                    <input type="email" name="email" placeholder="Correo electrónico o número de teléfono" class="fb-input" required autofocus value="{{ old('email') }}">
                    @error('email') 
                        <div class="text-[#dd3c10] text-[13px] mt-2 text-left border border-[#dd3c10] bg-[#ffebe8] p-2 rounded">
                            El correo electrónico que ingresaste no coincide con ninguna cuenta. 
                            <a href="{{ route('register') }}" class="font-bold hover:underline">Regístrate para crear una cuenta.</a>
                        </div> 
                    @enderror
                </div>

                <div>
                    <input type="password" name="password" placeholder="Contraseña" class="fb-input" required>
                    @error('password') 
                        <div class="text-[#dd3c10] text-[13px] mt-1 text-left">La contraseña es incorrecta.</div> 
                    @enderror
                </div>

                <button type="submit" class="fb-blue-btn shadow-sm">
                    Iniciar sesión
                </button>

                <div class="mt-3 pt-2">
                    <a href="{{ route('password.request') }}" class="text-[#1877f2] text-[14px] hover:underline">
                        ¿Olvidaste tu cuenta?
                    </a>
                </div>
                
                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-[#dadde1]"></div>
                    <span class="mx-2 text-[#96999e] text-sm">o</span>
                    <div class="flex-grow border-t border-[#dadde1]"></div>
                </div>

                <div class="text-center">
                    <a href="{{ route('register') }}" class="fb-green-btn inline-block px-4 py-2 text-[17px] no-underline hover:no-underline shadow-sm">
                        Crear cuenta nueva
                    </a>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-white pt-5 pb-5 w-full mt-auto border-t border-[#dddfe2]">
        <div class="w-[980px] mx-auto text-[#737373] text-[12px]">
            <div class="flex flex-wrap gap-2 mb-2">
                <span>Español</span><a href="#" class="text-[#385898] hover:underline">English (US)</a><a href="#" class="text-[#385898] hover:underline">Français (France)</a>
            </div>
            <div class="border-t border-[#ddd] my-2"></div>
            
            <div class="flex flex-wrap gap-x-4 gap-y-1 mb-4 text-[#385898]">
                <a href="{{ route('register') }}" class="hover:underline">Registrarte</a>
                <a href="#" class="hover:underline">Iniciar sesión</a>
                <a href="#" class="hover:underline">Messenger</a>
                <a href="#" class="hover:underline">Facebook Lite</a>
                <a href="#" class="hover:underline">Ayuda</a>
            </div>

            <div class="mb-4"> Larabook © {{ date('Y') }} </div>
        </div>
    </footer>

</body>
</html>