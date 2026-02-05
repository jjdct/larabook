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
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    .profile-nav-item:hover { background-color: #f5f6f7; }
    .profile-nav-item.active { color: #4b4f56; cursor: default; }
    
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
        text-decoration: none;
    }
    .action-btn:hover { background-color: #e9ebee; }
    
    .action-btn-blue {
        background-color: #4267b2;
        border: 1px solid #4267b2;
        color: white;
    }
    .action-btn-blue:hover { background-color: #365899; }

    .hidden-input { display: none; }
    
    /* Dropdown del menú Más */
    .more-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #dddfe2;
        border-radius: 0 0 3px 3px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, .25);
        z-index: 100;
        width: 200px;
        display: none;
    }
    .more-item {
        display: block;
        padding: 8px 12px;
        font-size: 13px;
        color: #1d2129;
        text-decoration: none;
    }
    .more-item:hover { background-color: #f5f6f7; color: #1d2129; }
</style>
@endpush

@section('content')
    <div class="-mt-4"> 
        
        <div class="bg-white border-b border-[#d3d6db] shadow-sm">
            <div class="max-w-[851px] mx-auto relative">
                
                <div class="relative w-full h-[315px] bg-gray-300 overflow-hidden group">
                    @if($user->cover)
                        <img src="{{ $user->cover }}" class="w-full h-full object-cover object-center">
                    @else
                        <div class="w-full h-full bg-gray-400 flex items-center justify-center text-gray-500 font-bold">Sin portada</div>
                    @endif
                    
                    <div class="absolute bottom-0 left-0 w-full h-[100px] cover-gradient"></div>

                    <h1 class="absolute bottom-[20px] left-[180px] text-white text-[30px] font-bold text-shadow drop-shadow-md flex items-center z-10">
                        {{ $user->name }}
                        @if($user->is_verified ?? false) 
                             <span class="text-[#1877f2] bg-white rounded-full w-5 h-5 inline-flex items-center justify-center text-[12px] ml-2" title="Verificado">✓</span>
                        @endif
                    </h1>

                    @if(Auth::id() === $user->id)
                    <form action="{{ route('profile.update_photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="cover">
                        <label class="absolute top-4 left-4 bg-black/50 hover:bg-black/70 text-white p-2 rounded cursor-pointer hidden group-hover:block text-sm font-bold transition z-20">
                            📷 Actualizar foto de portada
                            <input type="file" name="image" class="hidden-input" accept="image/*" onchange="this.form.submit()">
                        </label>
                    </form>
                    @endif
                </div>

                <div class="h-[43px] bg-white flex items-center justify-between pl-[180px]">
                    <div class="flex h-full relative" x-data="{ openMore: false }">
                        
                        <a href="{{ route('profile.show', $user->username) }}" class="profile-nav-item border-l border-[#e9eaed] text-[#4b4f56]">
                            Biografía
                        </a>
                        
                        <a href="{{ route('profile.about', $user->username) }}" class="profile-nav-item text-[#385898]">
                            Información
                        </a>
                        
                        <a href="{{ route('profile.friends', $user->username) }}" class="profile-nav-item text-[#385898]">
                            Amigos 
                            <span class="text-[#898f9c] font-normal pl-1">{{ $user->friends->count() }}</span>
                        </a>
                        
                        <a href="{{ route('profile.photos', $user->username) }}" class="profile-nav-item text-[#385898]">
                            Fotos
                        </a>
                        
                        <div class="relative h-full" @click.outside="openMore = false">
                            <div @click="openMore = !openMore" class="profile-nav-item text-[#385898] border-none flex items-center select-none">
                                Más ▼
                            </div>
                            <div x-show="openMore" class="more-dropdown" style="display: none;">
                                <a href="{{ route('profile.videos', $user->username) }}" class="more-item">Videos</a>
                                <a href="{{ route('profile.sports', $user->username) }}" class="more-item">Deportes</a>
                                <a href="{{ route('profile.music', $user->username) }}" class="more-item">Música</a>
                                <a href="{{ route('profile.movies', $user->username) }}" class="more-item">Películas</a>
                                <a href="{{ route('profile.books', $user->username) }}" class="more-item">Libros</a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <a href="{{ route('profile.likes', $user->username) }}" class="more-item">Me gusta</a>
                            </div>
                        </div>

                    </div>

                    <div class="flex gap-2 pr-4 items-center">
                        
                        @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="action-btn">✏️ <span class="hidden sm:inline">Editar perfil</span></a>
                            
                            <a href="{{ route('profile.log') }}" class="action-btn">Activity Log</a>

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

                <div class="absolute top-[160px] left-[15px] p-1 bg-white rounded-full border border-[rgba(0,0,0,.1)] z-10 group">
                    <img src="{{ $user->avatar }}" 
                         class="w-[160px] h-[160px] rounded-full object-cover border border-[rgba(0,0,0,.1)] bg-white relative z-10">
                    
                    @if(Auth::id() === $user->id)
                    <form action="{{ route('profile.update_photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="avatar">
                        <label class="absolute bottom-2 left-0 right-0 text-center bg-black/60 text-white text-xs py-1 cursor-pointer opacity-0 group-hover:opacity-100 transition z-20 rounded-b-full mx-1">
                            📷 Actualizar
                            <input type="file" name="image" class="hidden-input" accept="image/*" onchange="this.form.submit()">
                        </label>
                    </form>
                    @endif
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
                        <a href="{{ route('profile.edit') }}" class="block w-full text-center mt-3 bg-[#f5f6f7] hover:bg-[#e9ebee] py-1 text-xs font-bold text-[#4b4f56] rounded border border-[#ccd0d5] no-underline">
                            Editar detalles
                        </a>
                    @endif
                </div>

                <div class="card p-3">
                    <div class="flex justify-between items-end mb-3">
                        <div class="text-[#1d2129] font-bold text-sm">Amigos</div>
                        <a href="{{ route('profile.friends', $user->username) }}" class="text-[#365899] text-[12px] hover:underline">Ver todos</a>
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
                
                @if(Auth::id() === $user->id || Auth::user()->isFriendWith($user))
                <div class="card p-3" x-data="{ hasImage: false }">
                    <div class="flex gap-2 border-b border-[#e9eaed] pb-3 text-[12px] font-bold text-[#4b4f56]">
                        <div class="flex items-center gap-1 px-2 py-1 bg-[#f5f6f7] rounded hover:bg-[#ebedf0] cursor-pointer">
                            ✏️ Crear publicación
                        </div>
                        <label for="post-image-input" class="flex items-center gap-1 px-2 py-1 hover:bg-[#f5f6f7] rounded cursor-pointer border-l border-transparent">
                            📷 Foto/video
                        </label>
                    </div>

                    <div class="flex gap-2 mt-3">
                        <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full border border-black/10">
                        
                        <form action="{{ route('profile.post.store', $user) }}" method="POST" class="flex-grow" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="content" 
                                   class="w-full bg-transparent border-none py-2 text-[#1d2129] placeholder-gray-500 font-normal text-sm focus:ring-0" 
                                   placeholder="@if(Auth::id() === $user->id) ¿Qué estás pensando, {{ Auth::user()->first_name }}? @else Escribe algo a {{ $user->first_name }}... @endif"
                                   >
                            
                            <input type="file" name="image" id="post-image-input" class="hidden-input" accept="image/*" 
                                   @change="hasImage = true">

                            <div x-show="hasImage" class="text-xs text-green-600 mt-2 font-bold" style="display: none;">
                                📎 Imagen seleccionada (Se subirá al publicar)
                            </div>
                            
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-[#1877f2] hover:bg-[#166fe5] text-white px-4 py-1 rounded font-bold text-xs">
                                    Publicar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                @forelse($user->wallPosts as $post)
                    
                     <x-post-card :post="$post" />
                     
                @empty
                    <div class="card p-6 text-center text-gray-500">
                        <div class="text-3xl mb-2">📭</div>
                        @if(Auth::id() === $user->id)
                            Aún no has publicado nada. ¡Estrena tu muro!
                        @else
                            {{ $user->first_name }} no ha publicado nada aún.
                        @endif
                    </div>
                @endforelse

            </div>

        </div>
    </div>
@endsection