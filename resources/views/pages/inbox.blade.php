<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mensajes de {{ $page->name }} | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 11px; }
        .fb-header { background-color: #3b5998; height: 42px; padding: 0 20px; display: flex; items-center; justify-content: space-between; }
        .fb-sidebar { width: 250px; background-color: white; border-right: 1px solid #ccc; min-height: calc(100vh - 42px); }
        .fb-content { flex: 1; padding: 20px; }
        .msg-item { padding: 10px; border-bottom: 1px solid #e9eaed; cursor: pointer; }
        .msg-item:hover { background-color: #f6f7f9; }
        .active-msg { background-color: #d8dfea; }
    </style>
</head>
<body>

    <div class="fb-header text-white font-bold">
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard') }}" class="text-white text-lg no-underline">Larabook</a>
            <span class="opacity-50">/</span>
            <a href="{{ route('pages.show', $page->slug) }}" class="text-white hover:underline">{{ $page->name }}</a>
            <span class="opacity-50">/</span>
            <span>Mensajes</span>
        </div>
        <a href="{{ route('pages.show', $page->slug) }}" class="text-xs bg-white text-[#3b5998] px-2 py-1 rounded">Volver a la página</a>
    </div>

    <div class="flex h-[calc(100vh-42px)]">
        
        <div class="fb-sidebar overflow-y-auto">
            <div class="p-3 font-bold text-[#999] text-xs uppercase border-b">Bandeja de entrada</div>
            
            @forelse($conversations as $msg)
                <div class="msg-item flex gap-2 items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($msg->sender->name) }}&background=random" class="w-10 h-10 rounded">
                    <div>
                        <div class="font-bold text-[#333]">{{ $msg->sender->name }}</div>
                        <div class="text-[#777] text-xs truncate w-[160px]">{{ $msg->body }}</div>
                        <div class="text-[#999] text-[9px]">{{ $msg->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-gray-400">
                    No hay mensajes nuevos.
                </div>
            @endforelse
        </div>

        <div class="fb-content bg-white">
            <div class="text-center mt-20 text-gray-400">
                <h2 class="text-xl font-bold mb-2">Selecciona una conversación</h2>
                <p>Aquí verás los mensajes enviados a tu página.</p>
            </div>
        </div>

    </div>

</body>
</html>