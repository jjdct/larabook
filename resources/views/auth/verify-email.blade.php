<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu cuenta | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: Helvetica, Arial, sans-serif; color: #1c1e21; }
        .fb-header { background-color: #3b5998; background-image: linear-gradient(#4e69a2, #3b5998 50%); border-bottom: 1px solid #133783; }
        .card { background: white; border: 1px solid #dddfe2; border-radius: 4px; padding: 20px; width: 500px; }
        .fb-blue-btn { background-color: #4267b2; border: 1px solid #29487d; color: white; font-weight: bold; padding: 8px 20px; border-radius: 2px; cursor: pointer; }
        .fb-blue-btn:hover { background-color: #365899; }
        .link-grey { color: #90949c; font-size: 12px; text-decoration: none; }
        .link-grey:hover { text-decoration: underline; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <div class="fb-header h-[82px] flex items-center justify-center">
        <div class="w-[980px] px-4 md:px-0">
            <a href="/" class="text-white text-[40px] font-bold tracking-tighter no-underline hover:no-underline select-none">larabook</a>
        </div>
    </div>

    <div class="flex-grow flex items-center justify-center py-10">
        <div class="card shadow-sm">
            <h2 class="text-[20px] font-bold text-[#1c1e21] mb-2 border-b border-[#dadde1] pb-3">
                Verifica tu correo electrónico
            </h2>

            <div class="text-[14px] text-[#1c1e21] mt-4 mb-4 leading-5">
                @if (session('status') == 'verification-link-sent')
                    <div class="bg-[#e7f3ff] border border-[#1877f2] text-[#1877f2] px-3 py-2 rounded text-sm mb-4">
                        Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.
                    </div>
                @endif

                <p class="mb-2">
                    Gracias por registrarte. Antes de empezar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar?
                </p>
                <p>
                    Si no recibiste el correo, con gusto te enviaremos otro.
                </p>
            </div>

            <div class="flex justify-between items-center mt-6 pt-4 border-t border-[#dadde1]">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[#385898] hover:underline text-[13px] font-normal">
                        Cerrar sesión
                    </button>
                </form>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="fb-blue-btn text-[13px]">
                        Reenviar correo de verificación
                    </button>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-white pt-5 pb-5 w-full mt-auto border-t border-[#dddfe2]">
        <div class="w-[980px] mx-auto text-[#737373] text-[12px]">
            Larabook © {{ date('Y') }}
        </div>
    </footer>
</body>
</html>