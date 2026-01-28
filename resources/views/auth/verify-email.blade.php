<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Verifica tu correo | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 12px; color: #141823; }
        .fb-header { background-color: #3b5998; height: 82px; border-bottom: 1px solid #133783; }
        .fb-white-box { background-color: #fff; border: 1px solid #ccc; border-radius: 3px; max-width: 600px; margin: 40px auto; }
        .box-header { padding: 10px 12px; border-bottom: 1px solid #e5e5e5; background-color: #f6f7f9; font-weight: bold; font-size: 14px; }
        .box-content { padding: 20px; font-size: 13px; line-height: 1.4; }
        .btn-blue { background-color: #4267b2; border: 1px solid #29487d; color: white; font-weight: bold; padding: 5px 15px; cursor: pointer; font-size: 12px; }
        .btn-gray { background-color: #f6f7f9; border: 1px solid #ced0d4; color: #4b4f56; font-weight: bold; padding: 5px 10px; cursor: pointer; font-size: 12px; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="fb-header w-full flex items-center px-20">
        <a href="{{ url('/') }}" class="text-white text-4xl font-bold tracking-tighter decoration-none">larabook</a>
    </div>

    <div class="fb-white-box">
        <div class="box-header">Confirma tu dirección de correo electrónico</div>
        <div class="box-content">
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 bg-[#e9fbe9] border border-[#a4e388] p-2 text-[#3b6e22] font-bold">
                    Se ha enviado un nuevo enlace de verificación a tu correo.
                </div>
            @endif

            <p class="mb-4">
                Gracias por registrarte. Antes de empezar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar?
            </p>
            <p class="mb-6">Si no recibiste el correo, con gusto te enviaremos otro.</p>

            <div class="flex justify-between items-center border-t border-[#e5e5e5] pt-4 mt-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-blue">Reenviar correo de verificación</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[#3b5998] hover:underline cursor-pointer bg-transparent border-none">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>