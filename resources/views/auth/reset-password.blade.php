<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elige una contraseña nueva | Larabook</title>
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
            background-color: #f6f7f9;
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
            font-size: 16px; /* Letra grande para el password */
        }
        
        .password-strength-text {
            color: #777;
            font-size: 11px;
            margin-top: 4px;
            width: 300px;
        }

        .btn-blue {
            background-color: #4267b2;
            border: 1px solid #29487d;
            color: white;
            font-weight: bold;
            padding: 5px 15px;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-blue:hover { background-color: #365899; }
    </style>
</head>
<body>

    <div class="fb-header w-full">
        <div class="max-w-[980px] mx-auto px-4 h-full flex items-center">
            <a href="{{ url('/') }}" class="text-white text-4xl font-bold tracking-tighter cursor-pointer hover:no-underline decoration-none">
                larabook
            </a>
        </div>
    </div>

    <div class="fb-white-box">
        
        <div class="box-header">
            <h2 class="text-[14px] font-bold text-[#141823]">Elige una contraseña nueva</h2>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <input type="hidden" name="email" value="{{ $request->email }}">

            <div class="box-content">
                
                @if ($errors->any())
                    <div class="mb-4 bg-[#ffebe8] border border-[#dd3c10] p-2 text-[#333]">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <p class="text-[13px] mb-4 text-[#333]">
                    Una contraseña segura es una combinación de letras y signos de puntuación. Debe tener al menos 6 caracteres.
                </p>

                <div class="mb-2 text-[#666] font-bold">
                    Cambiando contraseña para: <span class="text-[#3b5998]">{{ $request->email }}</span>
                </div>
                
                <table class="w-full mt-4">
                    <tr>
                        <td class="font-bold text-[#666] w-40 align-middle text-right pr-4">Nueva contraseña:</td>
                        <td class="pb-2">
                            <input type="password" name="password" class="input-text" required autofocus>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold text-[#666] w-40 align-middle text-right pr-4">Confirmar contraseña:</td>
                        <td>
                            <input type="password" name="password_confirmation" class="input-text" required>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn-blue">Cambiar contraseña</button>
            </div>

        </form>
    </div>

    <div class="max-w-[980px] mx-auto text-center mt-10 text-[11px] text-[#737373]">
        Larabook © 2026
    </div>

</body>
</html>