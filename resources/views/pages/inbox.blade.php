<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mensajes de {{ $page->name }} | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 11px; color: #141823; }
        .fb-header { background-color: #3b5998; height: 42px; border-bottom: 1px solid #133783; padding: 0 20px; display: flex; items-center; justify-content: space-between; }
        
        .admin-container { width: 980px; margin: 20px auto; display: flex; gap: 20px; }
        .admin-sidebar { width: 180px; }
        .admin-content { flex: 1; background: white; border: 1px solid #c0c0c0; border-radius: 3px; min-height: 500px; display: flex; flex-direction: column; }
        
        .menu-item { display: block; padding: 8px 10px; color: #333; font-weight: bold; border-radius: 2px; text-decoration: none; font-size: 12px; }
        .menu-item:hover { background-color: #eff2f5; }
        .menu-item.active { background-color: #d8dfea; color: #3b5998; }

        .inbox-layout { display: flex; flex: 1; height: 100%; }
        .msg-list { width: 220px; border-right: 1px solid #e9eaed; overflow-y: auto; max-height: 600px; }
        .msg-view { flex: 1; padding: 0; display: flex; flex-direction: column; background-color: #fff; max-height: 600px; }
        
        /* Items de la lista */
        .msg-item { padding: 10px; border-bottom: 1px solid #e9eaed; cursor: pointer; display: flex; gap: 8px; text-decoration: none; color: inherit; }
        .msg-item:hover { background-color: #f6f7f9; }
        .msg-item.active { background-color: #e9ebee; border-right: 2px solid #3b5998; }
        
        /* Burbujas del chat */
        .chat-bubble-row { display: flex; padding: 8px 15px; gap: 10px; }
        .chat-bubble-row.own { flex-direction: row-reverse; }
        .chat-bubble { background: #f1f0f0; padding: 6px 10px; border-radius: 3px; max-width: 80%; border: 1px solid #e5e5e5; }
        .chat-bubble.own { background: #d8dfea; border-color: #bdc7d8; text-align: right; }
        
        .empty-state { padding: 40px; text-align: center; color: #999; }
        
        .btn-reply { background-color: #4e69a2; border: 1px solid #435a8b; color: white; font-weight: bold; padding: 3px 10px; cursor: pointer; }
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
        <a href="{{ route('pages.show', $page->slug) }}" class="text-xs bg-white text-[#3b5998] px-2 py-1 rounded">Ver página</a>
    </div>

    <div class="admin-container">
        
        <div class="admin-sidebar">
            <a href="{{ route('pages.edit', $page->slug) }}" class="menu-item">Información básica</a>
            <a href="{{ route('pages.inbox', $page->slug) }}" class="menu-item active">Mensajes</a>
            <a href="#" class="menu-item">Gestionar permisos</a>
            <a href="#" class="menu-item">Registro de actividad</a>
        </div>

        <div class="admin-content p-0 overflow-hidden">
            <div class="p-3 border-b border-[#e9eaed] bg-[#f6f7f9] font-bold text-[#4b4f56] text-xs flex justify-between items-center h-[40px]">
                <span>Bandeja de Entrada</span>
                <span class="font-normal text-gray-500 text-[10px]">
                    @if($activeChatUser)
                        Conversación con {{ $activeChatUser->name }}
                    @else
                        Responder como {{ $page->name }}
                    @endif
                </span>
            </div>

            <div class="inbox-layout">
                <div class="msg-list">
                    @forelse($conversations as $msg)
                        <a href="{{ route('pages.inbox', ['slug' => $page->slug, 'user_id' => $msg->sender_id]) }}" 
                           class="msg-item {{ (isset($activeChatUser) && $activeChatUser->id === $msg->sender_id) ? 'active' : '' }}">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($msg->sender->name) }}&background=random" class="w-8 h-8 rounded shrink-0">
                            <div class="overflow-hidden w-full">
                                <div class="font-bold text-[#333] text-[11px] truncate">{{ $msg->sender->name }}</div>
                                <div class="text-[#777] text-[10px] truncate">{{ $msg->body }}</div>
                                <div class="text-[#999] text-[9px] mt-1">{{ $msg->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 text-center text-gray-400 text-xs">No hay mensajes.</div>
                    @endforelse
                </div>

                <div class="msg-view">
                    @if($activeChatUser)
                        <div class="flex-1 overflow-y-auto p-3 space-y-2 bg-white" id="page-chat-scroll">
                            @foreach($activeChatMessages as $message)
                                @php
                                    // Es mensaje PROPIO si el sender_type es Page (la página lo envió)
                                    $isOwn = $message->sender_type === 'App\Models\Page';
                                @endphp
                                <div class="chat-bubble-row {{ $isOwn ? 'own' : '' }}">
                                    @if(!$isOwn)
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($activeChatUser->name) }}&background=random" class="w-8 h-8 rounded border border-gray-200">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($page->name) }}&background=white&color=333" class="w-8 h-8 rounded border border-gray-200">
                                    @endif

                                    <div class="chat-bubble {{ $isOwn ? 'own' : '' }}">
                                        @if($message->image_path)
                                            <div class="mb-1">
                                                <img src="{{ asset('storage/' . $message->image_path) }}" class="max-w-[150px] rounded">
                                            </div>
                                        @endif
                                        <p class="text-[#141823] text-[12px]">{{ $message->body }}</p>
                                        <div class="text-[9px] text-gray-400 mt-1">{{ $message->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-[#f2f2f2] border-t border-[#bdc7d8] p-2">
                            <form action="{{ route('pages.reply', ['slug' => $page->slug, 'user' => $activeChatUser->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="sender_page_id" value="{{ $page->id }}">
                                
                                <textarea name="body" class="w-full h-12 border border-[#bdc7d8] p-1 text-[12px] resize-none focus:outline-none mb-2" placeholder="Escribe una respuesta como {{ $page->name }}..."></textarea>
                                
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <label class="cursor-pointer flex items-center gap-1 text-[#3b5998] text-[11px] font-bold hover:underline">
                                            <span>📷 Añadir foto</span>
                                            <input type="file" name="image" class="hidden">
                                        </label>
                                    </div>
                                    <button type="submit" class="btn-reply">Responder</button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="empty-state">
                            <h2 class="text-lg font-bold mb-2">Mensajes de la página</h2>
                            <p class="text-xs">Selecciona una conversación.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @if($activeChatUser)
    <script>
        var container = document.getElementById("page-chat-scroll");
        if(container) container.scrollTop = container.scrollHeight;
    </script>
    @endif

</body>
</html>