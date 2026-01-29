<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solicitudes de amistad | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 11px; color: #141823; }
        .fb-dark-blue { background-color: #3b5998; }
        
        /* Contenedor principal blanco */
        .fb-container { width: 851px; margin: 20px auto; background: #fff; border: 1px solid #d3d6db; border-radius: 3px; min-height: 400px; }
        
        /* Encabezado de la sección */
        .fb-header-gray { background-color: #f6f7f9; padding: 10px 12px; border-bottom: 1px solid #e9eaed; font-weight: bold; font-size: 14px; color: #4b4f56; }
        
        /* Ítems de la lista */
        .request-item { padding: 12px; border-bottom: 1px solid #e9eaed; display: flex; gap: 10px; align-items: center; }
        .request-item:last-child { border-bottom: none; }
        
        /* Botones */
        .btn-confirm { background-color: #4267b2; border: 1px solid #29487d; color: white; font-weight: bold; padding: 5px 10px; cursor: pointer; border-radius: 2px; }
        .btn-confirm:hover { background-color: #365899; }

        .btn-ignore { background-color: #f6f7f9; border: 1px solid #ced0d4; color: #4b4f56; font-weight: bold; padding: 5px 10px; cursor: pointer; border-radius: 2px; }
        .btn-ignore:hover { background-color: #e9ebee; }

        .link-name { color: #3b5998; font-weight: bold; font-size: 14px; text-decoration: none; }
        .link-name:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <nav class="fb-dark-blue fixed top-0 w-full z-50 h-[42px] border-b border-[#29487d] flex items-center justify-between px-4 md:px-20 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="bg-white text-[#3b5998] w-6 h-6 rounded-[2px] flex items-center justify-center font-bold text-lg pb-1 hover:opacity-90">L</a>
        </div>
        <div class="flex items-center gap-4 text-white font-bold text-xs">
            <a href="{{ route('users.show', auth()->user()) }}" class="flex items-center gap-2 hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-5 h-5 bg-white p-[1px]">
                <span>{{ Auth::user()->name }}</span>
            </a>
            <a href="{{ route('dashboard') }}" class="hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">Inicio</a>
        </div>
    </nav>

    <div class="pt-14 pb-20">
        <div class="fb-container">
            <div class="fb-header-gray">
                Responde a las solicitudes de amistad
            </div>

            @if($requests->isEmpty())
                <div class="p-10 text-center text-gray-500">
                    <p class="text-lg mb-2">No tienes solicitudes nuevas.</p>
                    <a href="{{ route('dashboard') }}" class="text-[#3b5998] hover:underline">Volver al inicio</a>
                </div>
            @else
                @foreach($requests as $request)
                    <div class="request-item">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($request->sender->name) }}&background=random" class="w-[50px] h-[50px] border border-gray-300">
                        
                        <div class="flex-1 flex justify-between items-center">
                            <div>
                                <a href="{{ route('users.show', $request->sender) }}" class="link-name">
                                    {{ $request->sender->name }}
                                </a>
                                <div class="text-[#90949c] text-[11px]">
                                    Quiere ser tu amigo.
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <form action="{{ route('friends.accept', $request->sender) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-confirm">Confirmar</button>
                                </form>

                                <form action="{{ route('friends.reject', $request->sender) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-ignore">En otro momento</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @include('partials.chat-overlay')

</body>
</html>