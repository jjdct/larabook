<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Acceso denegado | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 11px; color: #141823; }
        .fb-header { background-color: #3b5998; height: 42px; border-bottom: 1px solid #133783; padding: 0 20px; display: flex; items-center; }
        .error-box { width: 600px; margin: 50px auto; background: white; border: 1px solid #c0c0c0; border-radius: 3px; padding: 20px; }
        .btn-blue { background-color: #4267b2; color: white; border: 1px solid #29487d; padding: 4px 10px; font-weight: bold; cursor: pointer; text-decoration: none; }
    </style>
</head>
<body>

    <div class="fb-header text-white font-bold">
        <a href="{{ url('/') }}" class="text-white text-lg no-underline">Larabook</a>
    </div>

    <div class="error-box">
        <h2 class="text-[14px] font-bold text-[#b94a48] mb-2 flex items-center gap-2">
            ⚠️ No tienes permiso para ver esta página
        </h2>
        <p class="text-[12px] mb-4 text-gray-600">
            Solo los administradores de la página pueden acceder a esta configuración o buzón de mensajes.
        </p>
        
        <div class="border-t border-[#e9eaed] pt-4 text-right">
            <a href="{{ url()->previous() }}" class="btn-blue">Ir a la página anterior</a>
            <a href="{{ route('dashboard') }}" class="ml-2 text-[#3b5998] hover:underline cursor-pointer">Ir al inicio</a>
        </div>
    </div>

</body>
</html>