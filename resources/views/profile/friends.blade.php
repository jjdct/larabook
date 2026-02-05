@extends('layouts.app')

@section('title', 'Amigos de ' . $user->name . ' | Larabook')

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
    
    /* === ESTILOS ESPECÍFICOS DE AMIGOS === */
    .friend-card {
        border: 1px solid #e9ebee; margin-bottom: 15px; display: flex; align-items: center; padding: 10px;
        border-radius: 3px;
    }
    .friend-avatar { width: 100px; height: 100px; object-fit: cover; border: 1px solid rgba(0,0,0,0.1); border-radius: 2px; }
    .friend-info { flex-grow: 1; padding-left: 15px; }
    .friend-name { font-weight: bold; font-size: 16px; color: #365899; text-decoration: none; }
    .friend-name:hover { text-decoration: underline; }
    .friend-mutual { font-size: 12px; color: #90949c; margin-top: 2px; }
    
    .sub-nav { display: flex; padding: 0 15px; border-bottom: 1px solid #e9eaed; }
    .sub-nav-item { padding: 15px; font-size: 14px; font-weight: 600; color: #65676b; cursor: pointer; }
    .sub-nav-item.active { color: #1c1e21; border-bottom: 3px solid #1877f2; }
    .sub-nav-item:hover { background-color: #f5f6f7; }
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
                        
                        <div class="profile-nav-item active border-b-2 border-[#385898] text-[#4b4f56]">
                            Amigos <span class="text-[#898f9c] font-normal pl-1">{{ $user->friends->count() }}</span>
                        </div>
                        
                        <a href="{{ route('profile.photos', $user->username) }}" class="profile-nav-item text-[#385898]">Fotos</a>
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
                    <div class="flex items-center gap-2">
                        <h2 class="text-[20px] font-bold text-[#1c1e21] flex items-center gap-2">
                            <span class="text-gray-500">👥</span> Amigos
                        </h2>
                    </div>
                    
                    <div class="flex gap-2">
                        @if(Auth::id() === $user->id)
                        <div class="relative">
                            <input type="text" placeholder="Buscar amigos" class="bg-[#f0f2f5] border-none rounded-full px-3 py-1 text-sm focus:ring-0">
                        </div>
                        <button class="text-[#1877f2] text-sm font-semibold hover:bg-blue-50 px-3 py-1 rounded">Solicitudes de amistad</button>
                        <button class="text-[#1877f2] text-sm font-semibold hover:bg-blue-50 px-3 py-1 rounded">Buscar amigos</button>
                        @endif
                    </div>
                </div>

                <div class="sub-nav">
                    <div class="sub-nav-item active">Todos los amigos</div>
                    <div class="sub-nav-item">Agregados recientemente</div>
                    <div class="sub-nav-item">Cumpleaños</div>
                    <div class="sub-nav-item">Universidad</div>
                    <div class="sub-nav-item">Ciudad actual</div>
                </div>

                <div class="p-4">
                    
                    @if($user->friends->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            <div class="text-4xl mb-2">😢</div>
                            {{ $user->first_name }} aún no tiene amigos agregados.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($user->friends as $friend)
                                <div class="friend-card">
                                    <a href="{{ route('profile.show', $friend->username) }}">
                                        <img src="{{ $friend->avatar }}" class="friend-avatar">
                                    </a>
                                    <div class="friend-info">
                                        <a href="{{ route('profile.show', $friend->username) }}" class="friend-name">
                                            {{ $friend->name }}
                                        </a>
                                        <div class="friend-mutual">
                                            @php $mutualCount = 5; /* Aquí iría la lógica real de amigos en común */ @endphp
                                            {{ $mutualCount }} amigos en común
                                        </div>
                                    </div>
                                    
                                    <div class="flex-shrink-0 pr-2">
                                        <button class="bg-[#e4e6eb] hover:bg-[#d8dadf] text-[#050505] px-3 py-1.5 rounded-md font-semibold text-[13px] flex items-center gap-1">
                                            ✓ Amigos
                                        </button>
                                    </div>
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