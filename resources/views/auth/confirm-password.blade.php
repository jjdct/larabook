<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar contraseña | Larabook</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif; color: #1c1e21; }
        .fb-header { background-color: #3b5998; background-image: linear-gradient(#4e69a2, #3b5998 50%); border-bottom: 1px solid #133783; }
        .card { background: white; border: 1px solid #dddfe2; border-radius: 4px; width: 500px; }
        .fb-input { border: 1px solid #bdc7d8; padding: 8px 10px; font-size: 16px; width: 100%; border-radius: 4px; }
        .btn-blue { background-color: #1877f2; color: white; font-weight: bold; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; }
        .btn-blue:hover { background-color: #166fe5; }
        .btn-cancel { background-color: #e4e6eb; color: #4b4f56; font-weight: bold; padding: 8px 15px; border-radius: 4px; text-decoration: none; margin-right: 10px; }
        .btn-cancel:hover { background-color: #d8dade; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <div class="fb-header h-[82px] flex items-center justify-center">
        <div class="w-[980px] px-4 md:px-0">
            <a href="/" class="text-white text-[40px] font-bold tracking-tighter no-underline hover:no-underline select-none">larabook</a>
        </div>
    </div>

    <div class="flex-grow flex items-start justify-center pt-12">
        <div class="card shadow-sm">
            <div class="px-5 py-3 border-b border-[#dadde1]">
                <h2 class="text-[18px] font-bold text-[#162643] m-0">Confirmación de seguridad</h2>
            </div>
            
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="p-5">
                    <p class="text-[15px] mb-4">
                        Esta es un área segura de Larabook. Ingresa tu contraseña para continuar.
                    </p>

                    <div class="flex items-center gap-4">
                        <label class="w-1/3 text-right font-bold text-[#90949c] text-sm">Contraseña:</label>
                        <div class="w-2/3">
                            <input type="password" name="password" class="fb-input" required autocomplete="current-password">
                            @error('password')
                                <div class="text-[#dd3c10] text-[12px] mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="px-5 py-3 bg-[#f5f6f7] border-t border-[#dadde1] text-right rounded-b">
                    <a href="javascript:history.back()" class="btn-cancel text-[13px]">Cancelar</a>
                    <button type="submit" class="btn-blue text-[13px]">Continuar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
