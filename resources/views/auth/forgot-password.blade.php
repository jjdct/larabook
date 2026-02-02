<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Olvidaste tu contraseña? | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif; color: #1c1e21; }
        
        /* Header */
        .fb-header { background-color: #3b5998; background-image: linear-gradient(#4e69a2, #3b5998 50%); border-bottom: 1px solid #133783; }
        
        /* Botones Header */
        .header-btn { 
            background-color: #4267b2; 
            border: 1px solid #29487d; 
            color: white; 
            font-weight: bold; 
            cursor: pointer; 
            font-size: 12px;
            padding: 4px 10px;
        }
        .header-btn:hover { background-color: #365899; }

        /* Tarjeta Central */
        .recovery-card {
            background-color: #fff;
            border: 1px solid #dddfe2;
            border-radius: 4px; /* Bordes ligeramente redondeados */
            width: 500px; /* Ancho fijo clásico de este diálogo */
        }
        
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #dadde1;
            font-size: 18px;
            font-weight: bold;
            color: #162643;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-footer {
            padding: 15px 20px;
            background-color: #f5f6f7; /* Gris muy clarito abajo */
            border-top: 1px solid #dadde1;
            text-align: right;
            border-radius: 0 0 4px 4px;
        }

        /* Inputs */
        .fb-input { 
            border: 1px solid #bdc7d8; 
            padding: 8px 10px;
            font-size: 16px;
            color: #1c1e21;
            width: 100%;
        }

        /* Botones de Acción */
        .btn-cancel {
            background-color: #e4e6eb;
            color: #4b4f56;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-right: 10px;
            border: 1px solid #ccd0d5;
        }
        .btn-cancel:hover { background-color: #d8dade; }

        .btn-search {
            background-color: #1877f2;
            color: white;
            font-weight: bold;
            padding: 8px 20px;
            border-radius: 4px;
            border: none;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-search:hover { background-color: #166fe5; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <div class="fb-header h-[82px] flex items-center justify-center w-full min-w-[980px]">
        <div class="w-[980px] px-4 md:px-0 flex justify-between items-center h-full">
            <a href="/" class="text-white text-[40px] font-bold tracking-tighter no-underline hover:no-underline mt-3">larabook</a>
            
            <form method="GET" action="{{ route('login') }}">
                <button type="submit" class="header-btn">Iniciar sesión</button>
            </form>
        </div>
    </div>

    <div class="flex-grow flex items-start justify-center pt-12 pb-20">
        <div class="recovery-card shadow-sm">
            
            <div class="card-header">
                Recupera tu cuenta
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="bg-[#e7f3ff] border border-[#1877f2] text-[#1877f2] px-3 py-2 rounded text-sm mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-[15px] text-[#1c1e21] mb-4">
                        Ingresa tu correo electrónico para buscar tu cuenta.
                    </p>

                    <input type="email" name="email" placeholder="Correo electrónico" class="fb-input" value="{{ old('email') }}" required autofocus>
                    
                    @error('email') 
                        <div class="text-[#dd3c10] text-[13px] mt-2 flex items-center gap-1">
                            ⚠️ No hemos encontrado ninguna cuenta con ese correo.
                        </div> 
                    @enderror
                </div>

                <div class="card-footer flex justify-end items-center">
                    <a href="{{ route('login') }}" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-search">Buscar</button>
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
            <div class="mb-4"> Larabook © {{ date('Y') }} </div>
        </div>
    </footer>

</body>
</html>