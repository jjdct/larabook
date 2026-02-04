@extends('layouts.app')

@section('title', $user->name . ' | Larabook')

@push('styles')
<style>
    /* Estilos específicos del Perfil */
    .cover-gradient {
        background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 20%);
    }
    .profile-nav-item {
        color: #4b4f56;
        font-weight: bold;
        font-size: 14px;
        padding: 0 15px;
        height: 43px;
        line-height: 43px;
        border-right: 1px solid #e9eaed;
        cursor: pointer;
    }
    .profile-nav-item:hover { background-color: #f5f6f7; }
    .profile-nav-item.active { color: #4b4f56; }
    
    .action-btn {
        background-color: #f5f6f7;
        border: 1px solid #ccd0d5;
        color: #4b4f56;
        font-weight: bold;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 2px;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }
    .action-btn:hover { background-color: #e9ebee; }
    
    /* Botón azul para acciones principales */
    .action-btn-blue {
        background-color: #4267b2;
        border: 1px solid #4267b2;
        color: white;
    }
    .action-btn-blue:hover { background-color: #365899; }
</style>
@endpush

@section('content')
    <div class="-mt-4"> 
        
        <div class="bg-white border-b border-[#d3d6db] shadow-sm">
            <div class="max-w-[851px] mx-auto relative">
                
                <div class="relative w-full h-[315px] bg-gray-300 overflow-hidden group cursor-pointer">
                    @if($user->cover)
                        <img src="{{ $user->cover }}" class="w-full h-full object-cover object-center">
                    @else
                        <div class="w-full h-full bg-gray-400"></div>
                    @endif
                    
                    <div class="absolute bottom-0 left-0 w-full h-[100px] cover-gradient"></div>

                    <h1 class="absolute bottom-[20px] left-[180px] text-white text-[30px] font-bold text-shadow drop-shadow-md flex items-center">
                        {{ $user->name }}
                        @if($user->is_verified ?? false) 
                             <span class="text-[#1877f2] bg-white rounded-full w-5 h-5 inline-flex items-center justify-center text-[12px] ml-2" title="Verificado">✓</span>
                        @endif
                    </h1>

                    @if(Auth::id() === $user->id)
                    <div class="absolute top-4 left-4 bg-black/50 hover:bg-black/70 text-white p-2 rounded cursor-pointer hidden group-hover:block text-sm font-bold transition">
                        📷 Actualizar foto de portada
                    </div>
                    @endif
                </div>

                <div class="h-[43px] bg-white flex items-center justify-between pl-[180px]">
                    <div class="flex h-full">
                        <div class="profile-nav-item border-l border-[#e9eaed] text-[#4b4f56]">Biografía</div>
                        <div class="profile-nav-item text-[#385898]">Información</div>
                        <div class="profile-nav-item text-[#385898]">
                            Amigos 
                            <span class="text-[#898f9c] font-normal pl-1">
                                {{ $user->friends->count() }}
                            </span>
                        </div>
                        <div class="profile-nav-item text-[#385898]">Fotos</div>
                        <div class="profile-nav-item text-[#385898] border-none flex items-center">Más ▼</div>
                    </div>

                    <div class="flex gap-2 pr-4 items-center">
                        
                        @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="action-btn">✏️ <span class="hidden sm:inline">Editar perfil</span></a>
                            <button class="action-btn">Activity Log</button>

                        @elseif(Auth::user()->isFriendWith($user))
                            <button class="action-btn text-green-600 border-green-600 bg-green-50 cursor-default">
                                ✓ Amigos
                            </button>
                            <form action="{{ route('friend.reject', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar a este amigo?');">
                                @csrf
                                <button type="submit" class="action-btn bg-red-50 text-red-600 border-red-200 ml-1 hover:bg-red-100" title="Eliminar de amigos">X</button>
                            </form>

                        @elseif(Auth::user()->hasSentRequestTo($user))
                            <button class="action-btn text-[#4b4f56] cursor-default bg-gray-100">Solicitud enviada</button>
                            <form action="{{ route('friend.reject', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="action-btn bg-white hover:bg-gray-100 text-gray-600">Cancelar</button>
                            </form>

                        @elseif(Auth::user()->hasPendingRequestFrom($user))
                            <form action="{{ route('friend.accept', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="action-btn action-btn-blue">Confirmar</button>
                            </form>
                            <form action="{{ route('friend.reject', $user) }}" method="POST" class="inline ml-1">
                                @csrf
                                <button type="submit" class="action-btn">Eliminar</button>
                            </form>

                        @else
                            <form action="{{ route('friend.add', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="action-btn action-btn-blue">👤+ <span class="hidden sm:inline">Agregar</span></button>
                            </form>

                        @endif

                        @if(Auth::id() !== $user->id)
                            <button class="action-btn">💬 <span class="hidden sm:inline">Mensaje</span></button>
                        @endif
                        
                    </div>
                </div>

                <div class="absolute top-[160px] left-[15px] p-1 bg-white rounded-full border border-[rgba(0,0,0,.1)] z-10">
                    <img src="{{ $user->avatar }}" 
                         class="w-[160px] h-[160px] rounded-full object-cover border border-[rgba(0,0,0,.1)] bg-white">
                </div>

            </div>
        </div>

        <div class="max-w-[851px] mx-auto mt-4 flex gap-3 pb-20">
            
            <div class="w-[306px] space-y-3">
                
                <div class="card p-3">
                    <div class="flex items-center gap-2 mb-3 text-[#1d2129] font-bold text-sm">
                        🌎 Intro
                    </div>
                    
                    @if($user->bio)
                        <div class="text-center text-sm mb-4 italic">
                            "{{ $user->bio }}"
                        </div>
                        <div class="border-t border-[#e5e5e5] my-3"></div>
                    @endif

                    <ul class="space-y-3 text-[12px] text-[#1d2129]">
                        <li class="flex gap-2 items-center"><span class="opacity-60">💼</span> Director ejecutivo en <strong>Larabook Inc.</strong></li>
                        <li class="flex gap-2 items-center"><span class="opacity-60">🎓</span> Estudió en <strong>Universidad de Laravel</strong></li>
                        
                        @if($user->location)
                        <li class="flex gap-2 items-center"><span class="opacity-60">📍</span> Vive en <strong>{{ $user->location }}</strong></li>
                        @endif
                        
                        <li class="flex gap-2 items-center"><span class="opacity-60">📡</span> Se unió en <strong>{{ $user->created_at->translatedFormat('F \d\e Y') }}</strong></li>
                    </ul>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <div class="w-full h-[100px] bg-gray-100 rounded flex items-center justify-center text-gray-400 text-xs border border-dashed border-gray-300">
                            (Sin fotos destacadas)
                        </div>
                    </div>
                    
                    @if(Auth::id() === $user->id)
                        <button class="w-full mt-3 bg-[#f5f6f7] hover:bg-[#e9ebee] py-1 text-xs font-bold text-[#4b4f56] rounded border border-[#ccd0d5]">
                            Editar detalles
                        </button>
                    @endif
                </div>

                <div class="card p-3">
                    <div class="flex justify-between items-end mb-3">
                        <div class="text-[#1d2129] font-bold text-sm">Amigos</div>
                        <a href="#" class="text-[#365899] text-[12px] hover:underline">Ver todos</a>
                    </div>
                    <div class="text-[#90949c] text-[12px] mb-3 -mt-2">{{ $user->friends->count() }} amigos</div>
                    
                    <div class="grid grid-cols-3 gap-1">
                        @forelse($user->friends->take(9) as $friend)
                            <div>
                                <a href="{{ route('profile.show', $friend->username) }}">
                                    <img src="{{ $friend->avatar }}" class="w-full h-[90px] object-cover bg-gray-200">
                                    <div class="text-[12px] font-bold text-[#365899] leading-tight mt-1 hover:underline truncate">
                                        {{ $friend->first_name }}
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-4 text-gray-400 text-xs">
                                No hay amigos para mostrar.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="text-[11px] text-[#90949c]">
                    Privacidad · Condiciones · Publicidad · Cookies · Larabook © {{ date('Y') }}
                </div>
            </div>

            <div class="w-[533px]">
                
                @if(Auth::id() === $user->id)
                <div class="card p-3">
                    <div class="flex gap-2 border-b border-[#e9eaed] pb-3 text-[12px] font-bold text-[#4b4f56]">
                        <div class="flex items-center gap-1 px-2 py-1 bg-[#f5f6f7] rounded hover:bg-[#ebedf0] cursor-pointer">✏️ Crear publicación</div>
                        <div class="flex items-center gap-1 px-2 py-1 hover:bg-[#f5f6f7] rounded cursor-pointer border-l border-transparent">📷 Foto/video</div>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full border border-black/10">
                        <div class="flex-grow py-2 text-[#90949c] font-normal text-sm cursor-text">
                            ¿Qué estás pensando, {{ Auth::user()->first_name }}?
                        </div>
                    </div>
                </div>
                @endif

                <div class="card mt-4">
                    <div class="p-3">
                        <div class="flex gap-2">
                            <img src="{{ $user->avatar }}" class="w-10 h-10 rounded-full border border-black/10">
                            <div>
                                <div class="text-[#365899] font-bold text-sm cursor-pointer hover:underline leading-4">{{ $user->name }}</div>
                                <div class="text-[#90949c] text-[12px] mt-0.5">
                                    {{ $user->created_at->format('d \d\e F') }} · {{ $user->location ?? 'Internet' }} · 🌎
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 text-[14px] text-[#1d2129]">
                            Se ha unido a Larabook. ¡El futuro es open source! 🐧
                        </div>
                    </div>
                    
                    <div class="px-3 py-2 text-[12px] text-[#90949c] border-b border-[#e9eaed] flex justify-between">
                        <div class="flex items-center gap-1">👍 1</div>
                    </div>

                    <div class="flex text-[#606770] font-bold text-[13px] py-1 border-t border-[#e9eaed]">
                        <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded">👍 Me gusta</div>
                        <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded">💬 Comentar</div>
                        <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded">🔄 Compartir</div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection