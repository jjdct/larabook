@extends('layouts.app')

@section('title', 'Fotos de ' . $user->name . ' | Larabook')

@push('styles')
<style>
    /* === REUTILIZAMOS ESTILOS DEL PERFIL === */
    .cover-gradient { background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 20%); }
    
    .profile-nav-item {
        color: #4b4f56; font-weight: bold; font-size: 14px; padding: 0 15px; height: 43px; 
        line-height: 43px; border-right: 1px solid #e9eaed; cursor: pointer; display: flex; 
        align-items: center; text-decoration: none;
    }
    .profile-nav-item:hover { background-color: #f5f6f7; }
    
    /* Pestaña Activa */
    .profile-nav-item.active { color: #4b4f56; cursor: default; }
    .profile-nav-item.current-page { color: #385898; background-color: #fff; }

    .action-btn {
        background-color: #f5f6f7; border: 1px solid #ccd0d5; color: #4b4f56; font-weight: bold;
        font-size: 12px; padding: 5px 10px; border-radius: 2px; display: flex; align-items: center;
        gap: 5px; cursor: pointer; text-decoration: none;
    }
    .action-btn:hover { background-color: #e9ebee; }
    .action-btn-blue { background-color: #4267b2; border: 1px solid #4267b2; color: white; }
    .action-btn-blue:hover { background-color: #365899; }
    
    .hidden-input { display: none; }
    
    /* === ESTILOS ESPECÍFICOS DE FOTOS === */
    .sub-nav { display: flex; padding: 0 15px; border-bottom: 1px solid #e9eaed; }
    .sub-nav-item { padding: 15px; font-size: 14px; font-weight: 600; color: #65676b; cursor: pointer; }
    .sub-nav-item.active { color: #1c1e21; border-bottom: 3px solid #1877f2; }
    .sub-nav-item:hover { background-color: #f5f6f7; }

    .photo-grid-item {
        position: relative;
        aspect-ratio: 1/1; /* Cuadrado perfecto */
        overflow: hidden;
        background-color: #f0f2f5;
        border: 1px solid rgba(0,0,0,0.1);
        cursor: pointer;
    }
    .photo-grid-item img {
        width: 100%; height: 100%; object-fit: cover; transition: transform 0.2s;
    }
    .photo-grid-item:hover img { transform: scale(1.03); }
    
    /* Overlay para editar (solo aparece en hover si eres el dueño) */
    .edit-overlay {
        position: absolute; top: 5px; right: 5px; background: rgba(0,0,0,0.6); 
        color: white; border-radius: 2px; padding: 2px 6px; font-size: 12px;
        opacity: 0; transition: opacity 0.2s;
    }
    .photo-grid-item:hover .edit-overlay { opacity: 1; }
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
                        <a href="{{ route('profile.friends', $user->username) }}" class="profile-nav-item text-[#385898]">
                            Amigos <span class="text-[#898f9c] font-normal pl-1">{{ $user->friends->count() }}</span>
                        </a>
                        
                        <div class="profile-nav-item active border-b-2 border-[#385898] text-[#4b4f56]">Fotos</div>
                        
                        <div class="profile-nav-item text-[#385898] border-none flex items-center">Más ▼</div>
                    </div>

                    <div class="flex gap-2 pr-4 items-center">
                        @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="action-btn">✏️ Editar perfil</a>
                        @elseif(Auth::user()->isFriendWith($user))
                            <button class="action-btn text-green-600 border-green-600 bg-green-50 cursor-default">✓ Amigos</button>
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
                
                <div class="p-4 flex justify-between items-center">
                    <h2 class="text-[20px] font-bold text-[#1c1e21] flex items-center gap-2">
                        <span class="text-gray-500">📷</span> Fotos
                    </h2>
                    @if(Auth::id() === $user->id)
                        <button class="text-[#1877f2] text-sm font-semibold hover:bg-blue-50 px-3 py-1 rounded">Agregar fotos</button>
                    @endif
                </div>

                <div class="sub-nav">
                    <div class="sub-nav-item">Fotos en las que apareces</div>
                    <div class="sub-nav-item active">Tus fotos</div>
                    <div class="sub-nav-item">Álbumes</div>
                </div>

                <div class="p-4">
                    
                    @php
                        // Recolectar todas las imágenes de los posts del usuario
                        // (En un sistema real esto se haría en el controlador)
                        $photos = collect();
                        foreach($user->wallPosts as $post) {
                            if(!empty($post->attachments) && is_array($post->attachments)) {
                                foreach($post->attachments as $img) {
                                    $photos->push([
                                        'url' => Storage::url($img),
                                        'post_id' => $post->id
                                    ]);
                                }
                            }
                        }
                    @endphp

                    @if($photos->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            <div class="text-4xl mb-2">🖼️</div>
                            {{ $user->first_name }} aún no ha subido fotos.
                        </div>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-1">
                            
                            <div class="photo-grid-item">
                                <a href="{{ route('profile.update_photo') }}"> <img src="{{ $user->avatar }}">
                                </a>
                            </div>

                             @if($user->cover)
                                <div class="photo-grid-item">
                                    <img src="{{ $user->cover }}">
                                </div>
                            @endif

                            @foreach($photos as $photo)
                                <div class="photo-grid-item group">
                                    <a href="{{ route('post.show', $photo['post_id']) }}">
                                        <img src="{{ $photo['url'] }}">
                                    </a>
                                    @if(Auth::id() === $user->id)
                                        <div class="edit-overlay">✏️</div>
                                    @endif
                                </div>
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