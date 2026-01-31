<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->name }} | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script> <style>
        body { background-color: #e9ebee; font-family: 'lucida grande', tahoma, verdana, arial, sans-serif; font-size: 11px; color: #141823; }
        .fb-dark-blue { background-color: #3b5998; }
        .fb-timeline-cover { width: 100%; height: 315px; background: linear-gradient(to bottom, #7f8c8d, #95a5a6); position: relative; border: 1px solid #000; border-bottom: none; }
        .fb-profile-pic { width: 160px; height: 160px; border: 4px solid white; position: absolute; bottom: -30px; left: 20px; background: white; box-shadow: 0 1px 1px rgba(0,0,0,.3); z-index: 10; }
        .fb-timeline-nav { background-color: white; border: 1px solid #d3d6db; border-top: none; height: 42px; border-radius: 0 0 3px 3px; }
        .fb-btn-gray { background: linear-gradient(#f6f7f9, #ebedf0); border: 1px solid #ced0d4; color: #4b4f56; font-weight: bold; font-size: 12px; padding: 4px 10px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; height: 28px; }
        .fb-box { background: white; border: 1px solid #d3d6db; border-radius: 3px; margin-bottom: 10px; }
        .fb-link { color: #3b5998; cursor: pointer; text-decoration: none; }
        .fb-link:hover { text-decoration: underline; }
    </style>
</head>
<body x-data="{ showMsgModal: false }"> <nav class="fb-dark-blue fixed top-0 w-full z-50 h-[42px] border-b border-[#29487d] flex items-center justify-between px-4 md:px-20 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="bg-white text-[#3b5998] w-6 h-6 rounded-[2px] flex items-center justify-center font-bold text-lg pb-1 hover:opacity-90">L</a>
            </div>
        <div class="flex items-center gap-4 text-white font-bold text-xs">
            <a href="{{ route('users.show', auth()->user()) }}" class="flex items-center gap-2 hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-5 h-5 bg-white p-[1px]">
                <span>{{ Auth::user()->name }}</span>
            </a>
            <div class="h-4 border-r border-[#5470ad] mx-1"></div>
            <a href="{{ route('dashboard') }}" class="hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">Inicio</a>
        </div>
    </nav>

    <div class="pt-12 max-w-[851px] mx-auto pb-20">
        
        @if($isRealAdmin && !$isAdminView)
            <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2 mb-4 rounded text-xs flex justify-between items-center">
                <span>👀 Estás viendo tu página como un visitante.</span>
                <a href="{{ route('pages.show', $page->slug) }}" class="font-bold underline">Volver a la vista de Administrador</a>
            </div>
        @endif

        @if(session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 mb-4 rounded text-xs">
                {{ session('status') }}
            </div>
        @endif

        <div class="relative mb-4">
            <div class="fb-timeline-cover overflow-hidden">
                <img src="https://picsum.photos/seed/{{ $page->slug }}/851/315?grayscale" class="w-full h-full object-cover">
                
                <h1 class="absolute bottom-4 left-[200px] text-white text-[30px] font-bold shadow-black drop-shadow-md leading-none">
                    {{ $page->name }}
                    <span class="block text-[14px] font-normal opacity-80 mt-1">{{ $page->category }}</span>
                </h1>
            </div>

            <div class="fb-timeline-nav flex items-center pl-[200px] pr-4 justify-between">
                <div class="flex h-full">
                    <div class="px-4 h-full flex items-center font-bold text-[#4b4f56] border-r border-[#e9eaed] cursor-pointer hover:bg-[#f6f7f9] text-[12px]">Biografía</div>
                    <div class="px-4 h-full flex items-center font-bold text-[#3b5998] border-r border-[#e9eaed] cursor-pointer hover:bg-[#f6f7f9] text-[12px]">Información</div>
                    <div class="px-4 h-full flex items-center font-bold text-[#3b5998] border-r border-[#e9eaed] cursor-pointer hover:bg-[#f6f7f9] text-[12px]">
                        Me gusta <span class="text-[#9197a3] ml-1 font-normal">{{ $page->fans->count() }}</span>
                    </div>
                </div>
                
                <div class="flex gap-2 items-center relative" x-data="{ showMenu: false }">
                    
                    @if($isAdminView)
                        <a href="{{ route('pages.edit', $page->slug) }}" class="fb-btn-gray border-yellow-400 bg-yellow-50 text-yellow-700">👑 Panel de Admin</a>
                        <a href="{{ route('pages.edit', $page->slug) }}" class="fb-btn-gray">Editar página</a>
                    @else
                        @if($isFan)
                             <button class="fb-btn-gray cursor-default text-[#3b5998]">
                                <span class="mr-1 text-[14px]">✓</span> Te gusta
                            </button>
                        @else
                            <button class="fb-btn-gray bg-[#f6f7f9] hover:bg-[#ebedf0]">
                                <span class="mr-1 text-[14px]">👍</span> Me gusta
                            </button>
                        @endif
                        
                        <button @click="showMsgModal = true" class="fb-btn-gray">💬 Mensaje</button>
                    @endif

                    <button @click="showMenu = !showMenu" @click.away="showMenu = false" class="fb-btn-gray px-2 relative">...</button>
                    
                    <div x-show="showMenu" class="absolute top-8 right-0 bg-white border border-gray-300 shadow-lg w-48 z-50 text-xs" style="display: none;">
                        @if($isRealAdmin)
                            @if($isAdminView)
                                <a href="{{ route('pages.show', ['slug' => $page->slug, 'view_as' => 'user']) }}" class="block px-3 py-2 hover:bg-[#3b5998] hover:text-white text-gray-700 border-b border-gray-200">
                                    👁️ Ver como visitante
                                </a>
                            @else
                                <a href="{{ route('pages.show', $page->slug) }}" class="block px-3 py-2 hover:bg-[#3b5998] hover:text-white text-gray-700 border-b border-gray-200">
                                    ⚙️ Volver a Admin
                                </a>
                            @endif
                        @endif
                        <a href="#" class="block px-3 py-2 hover:bg-[#3b5998] hover:text-white text-gray-700">Denunciar página</a>
                        <a href="#" class="block px-3 py-2 hover:bg-[#3b5998] hover:text-white text-gray-700">Bloquear página</a>
                    </div>

                </div>
            </div>

            <div class="fb-profile-pic overflow-hidden bg-white">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($page->name) }}&background=white&color=333&size=160&bold=true" class="w-full h-full">
            </div>
        </div>

        <div class="flex gap-3">
            <div class="w-[300px]">
                <div class="fb-box p-3">
                    <h3 class="text-[#4b4f56] font-bold text-[12px] mb-2">Información</h3>
                    <div class="text-[11px] text-[#141823] space-y-2">
                        @if($page->about)
                            <div class="mb-3">{{ $page->about }}</div>
                        @endif
                        <div class="flex gap-2"><span class="text-gray-400">📍</span> {{ $page->category }}</div>
                        <div class="flex gap-2"><span class="text-gray-400">📅</span> Se unió en {{ $page->created_at->format('Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="w-[536px]">
                
                @if($isAdminView)
                    <div class="fb-box">
                        <div class="bg-[#f6f7f9] border-b border-[#e9eaed] px-3 py-2 text-xs font-bold text-[#4b4f56]">
                            ✏️ Publicar como {{ $page->name }}
                        </div>
                        <div class="p-3">
                            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="page_id" value="{{ $page->id }}">
                                <textarea name="content" rows="2" placeholder="Escribe algo en esta página..." class="w-full border-none focus:ring-0 resize-none text-sm placeholder-gray-500"></textarea>
                                <div class="mt-2"><input type="file" name="image" class="text-xs"></div>
                                <div class="border-t border-[#e9eaed] mt-2 pt-2 text-right">
                                    <button type="submit" class="bg-[#4e69a2] text-white border border-[#435a8b] font-bold text-[12px] px-3 py-1">Publicar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                
                @forelse($posts as $post)
                    @include('partials.post', ['post' => $post])
                @empty
                    <div class="fb-box p-4 text-center text-gray-400 text-xs">
                        No hay publicaciones aún en esta página.
                    </div>
                @endforelse

            </div>
        </div>
    </div>

    <div x-show="showMsgModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white rounded border border-[#3b5998] shadow-lg w-[400px]">
            <div class="bg-[#6d84b4] text-white px-3 py-2 font-bold text-sm flex justify-between items-center">
                <span>Nuevo mensaje para {{ $page->name }}</span>
                <button @click="showMsgModal = false" class="text-white hover:text-gray-200">✕</button>
            </div>
            <div class="p-3">
                <form action="{{ route('pages.message', $page->id) }}" method="POST">
                    @csrf
                    <div class="mb-2 flex gap-2 items-center">
                        <span class="text-xs text-gray-500">Para:</span>
                        <span class="bg-[#e2e6ea] border border-[#ccd0d5] px-2 py-0.5 rounded text-xs font-bold text-[#333]">{{ $page->name }}</span>
                    </div>
                    <textarea name="body" rows="4" class="w-full border border-[#bdc7d8] p-2 text-sm focus:outline-none focus:border-[#3b5998]" placeholder="Escribe un mensaje..."></textarea>
                    <div class="mt-3 flex justify-end gap-2">
                        <button type="button" @click="showMsgModal = false" class="fb-btn-gray">Cancelar</button>
                        <button type="submit" class="bg-[#4267b2] text-white border border-[#29487d] font-bold text-[12px] px-4 py-1.5 rounded-[2px]">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.chat-overlay')

</body>
</html>