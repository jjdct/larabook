@extends('layouts.app')

@section('title', 'Deportes de ' . $user->name . ' | Larabook')

@push('styles')
<style>
    /* === ESTILOS BASE (Mismos de siempre) === */
    .cover-gradient { background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 20%); }
    .profile-nav-item { color: #4b4f56; font-weight: bold; font-size: 14px; padding: 0 15px; height: 43px; line-height: 43px; border-right: 1px solid #e9eaed; cursor: pointer; display: flex; align-items: center; text-decoration: none; }
    .profile-nav-item:hover { background-color: #f5f6f7; }
    .profile-nav-item.active { color: #4b4f56; cursor: default; }
    .action-btn { background-color: #f5f6f7; border: 1px solid #ccd0d5; color: #4b4f56; font-weight: bold; font-size: 12px; padding: 5px 10px; border-radius: 2px; display: flex; align-items: center; gap: 5px; cursor: pointer; text-decoration: none; }
    .action-btn:hover { background-color: #e9ebee; }
    .action-btn-blue { background-color: #4267b2; border: 1px solid #4267b2; color: white; }
    .action-btn-blue:hover { background-color: #365899; }
    .hidden-input { display: none; }

    /* === ESTILOS TARJETAS DE INTERESES === */
    .interest-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
    @media(max-width: 768px) { .interest-grid { grid-template-columns: 1fr; } }

    .interest-card {
        display: flex; align-items: center; background: white;
        border: 1px solid #e9ebee; border-radius: 3px; overflow: hidden;
    }
    .interest-img { width: 100px; height: 100px; object-fit: cover; }
    .interest-info { padding: 0 15px; flex-grow: 1; }
    .interest-title { font-weight: bold; color: #365899; font-size: 16px; display: block; }
    .interest-title:hover { text-decoration: underline; }
    .interest-meta { color: #90949c; font-size: 12px; margin-top: 2px; }
    .interest-action { padding-right: 15px; }
</style>
@endpush

@section('content')
    <div class="-mt-4"> 
        <div class="bg-white border-b border-[#d3d6db] shadow-sm">
            <div class="max-w-[851px] mx-auto relative">
                <div class="relative w-full h-[315px] bg-gray-300 overflow-hidden group">
                    @if($user->cover) <img src="{{ $user->cover }}" class="w-full h-full object-cover object-center">
                    @else <div class="w-full h-full bg-gray-400 flex items-center justify-center text-gray-500 font-bold">Sin portada</div> @endif
                    <div class="absolute bottom-0 left-0 w-full h-[100px] cover-gradient"></div>
                    <h1 class="absolute bottom-[20px] left-[180px] text-white text-[30px] font-bold text-shadow drop-shadow-md flex items-center z-10">
                        {{ $user->name }}
                        @if($user->is_verified ?? false) <span class="text-[#1877f2] bg-white rounded-full w-5 h-5 inline-flex items-center justify-center text-[12px] ml-2">✓</span> @endif
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
                        <div class="profile-nav-item active border-b-2 border-[#385898] text-[#4b4f56]">Deportes</div>
                    </div>
                    <div class="flex gap-2 pr-4 items-center">
                        @if(Auth::id() === $user->id) <a href="{{ route('profile.edit') }}" class="action-btn">✏️ Editar perfil</a>
                        @elseif(Auth::user()->isFriendWith($user)) <button class="action-btn text-green-600 bg-green-50 border-green-600 cursor-default">✓ Amigos</button>
                        @elseif(Auth::user()->hasSentRequestTo($user)) <button class="action-btn bg-gray-100 cursor-default">Solicitud enviada</button>
                        @elseif(Auth::user()->hasPendingRequestFrom($user)) <form action="{{ route('friend.accept', $user) }}" method="POST"><button class="action-btn action-btn-blue">Confirmar</button></form>
                        @else <form action="{{ route('friend.add', $user) }}" method="POST"><button class="action-btn action-btn-blue">👤+ Agregar</button></form>
                        @endif
                        @if(Auth::id() !== $user->id) <button class="action-btn">💬 Mensaje</button> @endif
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
                <div class="p-4 border-b border-[#e5e5e5] flex justify-between items-center">
                    <h2 class="text-[20px] font-bold text-[#1c1e21] flex items-center gap-2"><span class="text-gray-500">⚽</span> Deportes</h2>
                    @if(Auth::id() === $user->id) <button class="text-[#1877f2] text-sm font-semibold hover:bg-blue-50 px-3 py-1 rounded">+ Agregar equipo</button> @endif
                </div>

                <div class="p-4">
                    <div class="interest-grid">
                        @foreach(['Real Madrid', 'Los Angeles Lakers', 'Scuderia Ferrari', 'New York Yankees'] as $team)
                        <div class="interest-card">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($team) }}&background=random&size=100" class="interest-img">
                            <div class="interest-info">
                                <a href="#" class="interest-title">{{ $team }}</a>
                                <div class="interest-meta">Equipo deportivo · {{ rand(10, 500) }} M seguidores</div>
                            </div>
                            <div class="interest-action">
                                <button class="bg-[#f5f6f7] hover:bg-[#e9ebee] border border-[#ccd0d5] text-[#4b4f56] font-bold text-xs px-3 py-1.5 rounded flex items-center gap-1">
                                    👍 Te gusta
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-[11px] text-[#90949c] mt-2">Privacidad · Condiciones · Publicidad · Cookies · Larabook © {{ date('Y') }}</div>
        </div>
    </div>
@endsection