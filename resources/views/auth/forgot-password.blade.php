<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>¿Olvidaste tu contraseña? | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-color: #e9ebee; 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
            font-size: 12px;
            color: #141823;
        }
        .fb-header { background-color: #3b5998; height: 82px; border-bottom: 1px solid #133783; }
        
        .fb-white-box {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 3px;
            max-width: 600px;
            margin: 40px auto;
        }
        
        .box-header {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e5e5;
            background-color: #f6f7f9; /* Cabecera grisácea típica de FB */
        }
        
        .box-content { padding: 20px; }
        
        .box-footer {
            padding: 8px 12px;
            background-color: #f6f7f9;
            border-top: 1px solid #e5e5e5;
            text-align: right;
            border-radius: 0 0 3px 3px;
        }

        .input-text {
            border: 1px solid #bdc7d8;
            padding: 8px;
            width: 300px;
            font-size: 14px;
        }

        .btn-blue {
            background-color: #4267b2;
            border: 1px solid #29487d;
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-blue:hover { background-color: #365899; }

        .btn-gray {
            background-color: #f6f7f9;
            border: 1px solid #ced0d4;
            color: #4b4f56;
            font-weight: bold;
            padding: 5px 10px;
            text-decoration: none;
            margin-right: 5px;
            font-size: 12px;
        }
        .btn-gray:hover { background-color: #e9ebee; }
        
        .fb-btn-signup {
            background-color: #42b72a;
            border: 1px solid #2c8415;
            color: white;
            font-weight: bold;
            font-size: 13px;
            padding: 5px 10px;
            border-radius: 2px;
        }
    </style>
</head>
<body>

    <div class="fb-header w-full">
        <div class="max-w-[980px] mx-auto px-4 h-full flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-white text-4xl font-bold tracking-tighter cursor-pointer hover:no-underline decoration-none">
                larabook
            </a>
            
            <div class="flex gap-2">
                <a href="{{ route('login') }}" class="bg-[#4267b2] text-white text-xs font-bold px-2 py-1 border border-[#29487d] h-7 flex items-center">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="fb-btn-signup h-7 flex items-center">Registrarte</a>
            </div>
        </div>
    </div>

    <div class="fb-white-box">
        
        <div class="box-header">
            <h2 class="text-[14px] font-bold text-[#141823]">Identifica tu cuenta</h2>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="box-content">
                
                @if (session('status'))
                    <div class="mb-4 bg-[#e9fbe9] border border-[#a4e388] p-2 text-[#3b6e22] font-bold">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-[#ffebe8] border border-[#dd3c10] p-2 text-[#333]">
                        No pudimos encontrar tu cuenta con esa información.
                    </div>
                @endif

                <p class="text-[13px] mb-4 text-[#333]">Introduce tu correo electrónico o número de teléfono para buscar tu cuenta.</p>
                
                <table class="w-full">
                    <tr>
                        <td class="font-bold text-[#666] w-40 align-middle">Correo electrónico:</td>
                        <td>
                            <input type="email" name="email" class="input-text" required autofocus value="{{ old('email') }}">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="box-footer">
                <a href="{{ route('login') }}" class="btn-gray">Cancelar</a>
                <button type="submit" class="btn-blue">Buscar</button>
            </div>

        </form>
    </div>

    <div class="max-w-[980px] mx-auto text-center mt-10 text-[11px] text-[#737373]">
        Larabook © 2026 · <span class="text-[#3b5998] hover:underline cursor-pointer">Español</span>
    </div>

</body>
</html>