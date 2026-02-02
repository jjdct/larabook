<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegir una contraseña nueva | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif; color: #1c1e21; }
        .fb-header { background-color: #3b5998; background-image: linear-gradient(#4e69a2, #3b5998 50%); border-bottom: 1px solid #133783; }
        .card { background: white; border: 1px solid #dddfe2; border-radius: 4px; width: 500px; }
        .fb-input { border: 1px solid #bdc7d8; padding: 10px; font-size: 16px; width: 100%; border-radius: 5px; }
        
        .btn-blue { background-color: #1877f2; color: white; font-weight: bold; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; width: 100%; font-size: 18px; }
        .btn-blue:hover { background-color: #166fe5; }
        
        .separator { border-top: 1px solid #dadde1; margin: 20px 0; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <div class="fb-header h-[82px] flex items-center justify-center">
        <div class="w-[980px] px-4 md:px-0">
            <a href="/" class="text-white text-[40px] font-bold tracking-tighter no-underline hover:no-underline select-none">larabook</a>
        </div>
    </div>

    <div class="flex-grow flex items-center justify-center py-10">
        <div class="card p-6 shadow-sm">
            <h2 class="text-[22px] font-bold text-[#1c1e21] mb-1">Elige una contraseña nueva</h2>
            <p class="text-[15px] text-[#606770] mb-5">
                Crea una contraseña segura con una combinación de letras, números y signos de puntuación.
            </p>

            <div class="separator"></div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <input type="email" name="email" class="fb-input bg-gray-100 text-gray-500" value="{{ old('email', $request->email) }}" required readonly placeholder="Correo electrónico">
                     @error('email') <div class="text-[#dd3c10] text-[12px] mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <input type="password" name="password" class="fb-input" required autocomplete="new-password" placeholder="Nueva contraseña" autofocus>
                    @error('password') <div class="text-[#dd3c10] text-[12px] mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <input type="password" name="password_confirmation" class="fb-input" required autocomplete="new-password" placeholder="Confirmar nueva contraseña">
                    @error('password_confirmation') <div class="text-[#dd3c10] text-[12px] mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-blue shadow-sm">
                        Continuar
                    </button>
                </div>
                
                <div class="text-center mt-4">
                     <a href="{{ route('login') }}" class="text-[#1877f2] text-sm hover:underline">Omitir</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="text-center pb-4 text-[#737373] text-xs">
         Larabook © {{ date('Y') }}
    </div>

</body>
</html>