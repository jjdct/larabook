<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Control de seguridad | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 12px; color: #141823; }
        .fb-header { background-color: #3b5998; height: 82px; border-bottom: 1px solid #133783; }
        .fb-white-box { background-color: #fff; border: 1px solid #ccc; border-radius: 3px; max-width: 500px; margin: 40px auto; }
        .box-header { padding: 10px 12px; border-bottom: 1px solid #e5e5e5; background-color: #f6f7f9; font-weight: bold; font-size: 14px; }
        .box-content { padding: 20px; font-size: 13px; }
        .input-text { border: 1px solid #bdc7d8; padding: 5px; width: 200px; font-size: 12px; }
        .btn-blue { background-color: #4267b2; border: 1px solid #29487d; color: white; font-weight: bold; padding: 4px 10px; cursor: pointer; font-size: 12px; }
    </style>
</head>
<body>
    <div class="fb-header w-full flex items-center px-20">
        <a href="{{ url('/') }}" class="text-white text-4xl font-bold tracking-tighter decoration-none">larabook</a>
    </div>

    <div class="fb-white-box">
        <div class="box-header">Control de seguridad</div>
        
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="box-content">
                <p class="mb-4 text-gray-600">
                    Esta es un área segura de Larabook. Por favor confirma tu contraseña para continuar.
                </p>

                @if ($errors->any())
                    <div class="mb-4 text-red-600 font-bold">La contraseña es incorrecta.</div>
                @endif

                <table class="w-full">
                    <tr>
                        <td class="text-right pr-4 font-bold text-gray-500 w-1/3">Contraseña:</td>
                        <td>
                            <input type="password" name="password" class="input-text" required autofocus>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="bg-[#f6f7f9] p-2 border-t border-[#e5e5e5] text-right rounded-b-[3px]">
                <button type="submit" class="btn-blue">Continuar</button>
            </div>
        </form>
    </div>
</body>
</html>