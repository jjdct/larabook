@extends('layouts.app')

@section('title', 'Videos de ' . $user->name . ' | Larabook')

@push('styles')
<style>
    /* === ESTILOS BASE DEL PERFIL (Igual que los anteriores) === */
    .cover-gradient { background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 20%); }
    .profile-nav-item { color: #4b4f56; font-weight: bold; font-size: 14px; padding: 0 15px; height: 43px; line-height: 43px; border-right: 1px solid #e9eaed; cursor: pointer; display: flex; align-items: center; text-decoration: none; }
    .profile-nav-item:hover { background-color: #f5f6f7; }
    .profile-nav-item.active { color: #4b4f56; cursor: default; }
    .action-btn { background-color: #f5f6f7; border: 1px solid #ccd0d5; color: #4b4f56; font-weight: bold; font-size: 12px; padding: 5px 10px; border-radius: 2px; display: flex; align-items: center; gap: 5px; cursor: pointer; text-decoration: none; }
    .action-btn:hover { background-color: #e9ebee; }
    .action-btn-blue { background-color: #4267b2; border: 1px solid #4267b2; color: white; }
    .action-btn-blue:hover { background-color: #365899; }
    .hidden-input { display: none; }

    /* === ESTILOS ESPECÍFICOS DE VIDEOS === */
    .video-grid-item {
        position: relative;
        aspect-ratio: 16/9; /* Formato panorámico para videos */
        background-color: #000;
        border-radius: 4px;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid rgba(0,0,0,0.1);
    }
    .video-grid-item video {
        width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: opacity 0.2s;
    }
    .video-grid-item:hover video { opacity: 0.6; }
    
    /* Botón Play Overlay */
    .play-icon {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        width: 40px; height: 40px; background: rgba(0,0,0,0.6); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; border: 2px solid white;
        pointer-events: none; /* Click atraviesa al link */
    }
    .play-triangle {
        width: 0; height: 0; border-left: 12px solid white; border-top: 8px solid transparent; border-bottom: 8px solid transparent; margin-left: 4px;
    }

    .video-duration {
        position: absolute; bottom: 5px; right: 5px; background: rgba(0,0,0,0.8);
        color: white; font-size: 11px; padding: 1px 4px; border-radius: 2px; font-weight: bold;
    }
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
                        @if($user->is_verified ?? false) <span class="text-[#1877f2] bg-white rounded-full w-5 h-5 inline-flex items-center justify-center text-[12px] ml-2" title="Verificado">✓</span> @endif
                    </h1>
                    
                    @if(Auth::id() === $user->id)
                    <form action="{{ route('profile.update_photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf <input type="hidden" name="type" value="cover">
                        <label class="absolute top-4 left-4 bg-black/50 hover:bg-black/70 text-white p-2 rounded cursor-pointer hidden group-hover:block text-sm font-bold transition z-20">
                            📷 Actualizar portada <input type="file" name="image" class="hidden-input" accept="image/*" onchange="this.form.submit()">
                        </label>
                    </form>
                    @endif
                </div>

                <div class="h-[43px] bg-white flex items-center justify-between pl-[180px]">
                    <div class="flex h-full">
                        <a href="{{ route('profile.show', $user->username) }}" class="profile-nav-item border-l border-[#e9eaed] text-[#385898]">Biografía</a>
                        <a href="{{ route('profile.about', $user->username) }}" class="profile-nav-item text-[#385898]">Información</a>
                        <a href="{{ route('profile.friends', $user->username) }}" class="profile-nav-item text-[#385898]">Amigos <span class="text-[#898f9c] pl-1">{{ $user->friends->count() }}</span></a>
                        <a href="{{ route('profile.photos', $user->username) }}" class="profile-nav-item text-[#385898]">Fotos</a>
                        
                        <div class="profile-nav-item active border-b-2 border-[#385898] text-[#4b4f56]">Videos</div>
                    </div>

                    <div class="flex gap-2 pr-4 items-center">
                        @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="action-btn">✏️ Editar perfil</a>
                        @elseif(Auth::user()->isFriendWith($user))
                            <button class="action-btn text-green-600 bg-green-50 border-green-600 cursor-default">✓ Amigos</button>
                        @elseif(Auth::user()->hasSentRequestTo($user))
                            <button class="action-btn bg-gray-100 cursor-default">Solicitud enviada</button>
                        @elseif(Auth::user()->hasPendingRequestFrom($user))
                            <form action="{{ route('friend.accept', $user) }}" method="POST"><button class="action-btn action-btn-blue">Confirmar</button></form>
                        @else
                            <form action="{{ route('friend.add', $user) }}" method="POST"><button class="action-btn action-btn-blue">👤+ Agregar</button></form>
                        @endif

                        @if(Auth::id() !== $user->id)
                            <button class="action-btn">💬 Mensaje</button>
                        @endif
                    </div>
                </div>

                <div class="absolute top-[160px] left-[15px] p-1 bg-white rounded-full border border-[rgba(0,0,0,.1)] z-10 group">
                    <img src="{{ $user->avatar }}" class="w-[160px] h-[160px] rounded-full object-cover border border-[rgba(0,0,0,.1)] bg-white relative z-10">
                    @if(Auth::id() === $user->id)
                    <form action="{{ route('profile.update_photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf <input type="hidden" name="type" value="avatar">
                        <label class="absolute bottom-2 left-0 right-0 text-center bg-black/60 text-white text-xs py-1 cursor-pointer opacity-0 group-hover:opacity-100 transition z-20 rounded-b-full mx-1">
                            📷 Actualizar <input type="file" name="image" class="hidden-input" accept="image/*" onchange="this.form.submit()">
                        </label>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w-[851px] mx-auto mt-4 pb-20">
            
            <div class="bg-white border border-[#dddfe2] rounded-sm min-h-[400px]">
                
                <div class="p-4 flex justify-between items-center border-b border-[#e5e5e5]">
                    <h2 class="text-[20px] font-bold text-[#1c1e21] flex items-center gap-2">
                        <span class="text-gray-500">🎥</span> Videos
                    </h2>
                    @if(Auth::id() === $user->id)
                        <button class="text-[#1877f2] text-sm font-semibold hover:bg-blue-50 px-3 py-1 rounded">
                            + Agregar video
                        </button>
                    @endif
                </div>

                <div class="p-4">
                    
                    @php
                        // Filtramos posts que tengan attachments con extensiones de video
                        $videos = collect();
                        $videoExtensions = ['mp4', 'mov', 'avi', 'webm', 'mkv'];

                        foreach($user->wallPosts as $post) {
                            if(!empty($post->attachments) && is_array($post->attachments)) {
                                foreach($post->attachments as $file) {
                                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                                    if(in_array(strtolower($ext), $videoExtensions)) {
                                        $videos->push([
                                            'url' => Storage::url($file),
                                            'post_id' => $post->id,
                                            'title' => Str::limit($post->content, 30) ?: 'Video sin título'
                                        ]);
                                    }
                                }
                            }
                        }
                    @endphp

                    @if($videos->isEmpty())
                        <div class="text-center py-12 text-gray-500">
                            <div class="text-4xl mb-3">🎬</div>
                            @if(Auth::id() === $user->id)
                                <div class="font-bold text-lg mb-1">No tienes videos</div>
                                <div class="text-sm">Sube videos en tu muro para que aparezcan aquí.</div>
                            @else
                                <div class="font-bold text-lg">{{ $user->first_name }} no tiene videos.</div>
                            @endif
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($videos as $video)
                                <a href="{{ route('post.show', $video['post_id']) }}" class="video-grid-item group">
                                    <video src="{{ $video['url'] }}#t=1" preload="metadata" muted></video>
                                    
                                    <div class="play-icon">
                                        <div class="play-triangle"></div>
                                    </div>
                                    
                                    <div class="video-duration">▶ Video</div>

                                    <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/80 to-transparent p-2 pt-6 opacity-0 group-hover:opacity-100 transition">
                                        <div class="text-white text-xs font-bold truncate">{{ $video['title'] }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

            <div class="text-[11px] text-[#90949c] mt-2">
                Privacidad · Condiciones · Publicidad · Cookies · Larabook © {{ date('Y') }}
            </div>

        </div>
    </div>
@endsection