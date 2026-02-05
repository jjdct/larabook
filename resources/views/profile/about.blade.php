@extends('layouts.app')

@section('title', 'Información de ' . $user->name . ' | Larabook')

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
    
    /* Clase específica para la pestaña activa (Azul) */
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
    
    /* === ESTILOS ESPECÍFICOS DE LA SECCIÓN ABOUT === */
    .about-menu-item {
        padding: 10px 15px; font-size: 14px; color: #65676b; cursor: pointer; border-left: 3px solid transparent;
        font-weight: 600;
    }
    .about-menu-item:hover { background-color: #f5f6f7; color: #1c1e21; }
    .about-menu-item.active { border-left-color: #385898; color: #385898; background-color: #f5f6f7; }

    .about-section-title {
        text-transform: uppercase; font-size: 12px; font-weight: bold; color: #65676b; margin-bottom: 10px;
    }
    .about-row {
        display: flex; gap: 15px; padding: 15px 0; border-bottom: 1px solid #e5e5e5;
    }
    .about-row:last-child { border-bottom: none; }
    .about-icon-circle {
        width: 24px; height: 24px;
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
                        
                        <div class="profile-nav-item active border-b-2 border-[#385898] text-[#4b4f56]">Información</div>
                        
                        <a href="{{ route('profile.friends', $user->username) }}" class="profile-nav-item text-[#385898]">
                            Amigos <span class="text-[#898f9c] font-normal pl-1">{{ $user->friends->count() }}</span>
                        </a>
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
                
                <div class="p-4 border-b border-[#e5e5e5]">
                    <h2 class="text-[20px] font-bold text-[#1c1e21] flex items-center gap-2">
                        <span class="text-gray-500">👤</span> Información
                    </h2>
                </div>

                <div class="flex">
                    <div class="w-1/3 border-r border-[#e5e5e5] py-2">
                        <div class="about-menu-item active">Panorama general</div>
                        <div class="about-menu-item">Empleo y formación</div>
                        <div class="about-menu-item">Lugares de residencia</div>
                        <div class="about-menu-item">Información básica y de contacto</div>
                        <div class="about-menu-item">Familia y relaciones</div>
                        <div class="about-menu-item">Información sobre ti</div>
                        <div class="about-menu-item">Acontecimientos importantes</div>
                    </div>

                    <div class="w-2/3 p-4">
                        
                        <div class="mb-6">
                            <div class="about-section-title">Empleo</div>
                            <div class="about-row">
                                <div class="text-2xl text-gray-400">💼</div>
                                <div>
                                    <div class="text-[#1c1e21] text-[15px]">Director ejecutivo en <strong>Larabook Inc.</strong></div>
                                    <div class="text-[#65676b] text-[13px]">Ciudad de México</div>
                                    @if(Auth::id() === $user->id)
                                        <div class="mt-1 text-blue-600 text-[13px] cursor-pointer hover:underline">Editar empleo</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="about-section-title">Universidad</div>
                            <div class="about-row">
                                <div class="text-2xl text-gray-400">🎓</div>
                                <div>
                                    <div class="text-[#1c1e21] text-[15px]">Estudió Ingeniería en Sistemas en <strong>Universidad de Laravel</strong></div>
                                    <div class="text-[#65676b] text-[13px]">Generación 2024</div>
                                    @if(Auth::id() === $user->id)
                                        <div class="mt-1 text-blue-600 text-[13px] cursor-pointer hover:underline">Editar formación</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="about-section-title">Lugares de residencia</div>
                            @if($user->location)
                                <div class="about-row">
                                    <div class="text-2xl text-gray-400">📍</div>
                                    <div>
                                        <div class="text-[#1c1e21] text-[15px]">Vive en <strong>{{ $user->location }}</strong></div>
                                        <div class="text-[#65676b] text-[13px]">Ciudad actual</div>
                                    </div>
                                </div>
                            @else
                                <div class="text-gray-500 italic text-sm p-2">No hay información de ubicación.</div>
                            @endif
                        </div>

                        <div class="mb-6">
                            <div class="about-section-title">Información básica</div>
                            
                            <div class="about-row">
                                <div class="text-2xl text-gray-400">✉️</div>
                                <div>
                                    <div class="text-[#1c1e21] text-[15px]">{{ $user->email }}</div>
                                    <div class="text-[#65676b] text-[13px]">Correo electrónico</div>
                                </div>
                            </div>

                            <div class="about-row">
                                <div class="text-2xl text-gray-400">🎂</div>
                                <div>
                                    <div class="text-[#1c1e21] text-[15px]">14 de Febrero</div>
                                    <div class="text-[#65676b] text-[13px]">Fecha de nacimiento</div>
                                </div>
                            </div>
                            
                            <div class="about-row">
                                <div class="text-2xl text-gray-400">🚻</div>
                                <div>
                                    <div class="text-[#1c1e21] text-[15px]">Personalizado</div>
                                    <div class="text-[#65676b] text-[13px]">Género</div>
                                </div>
                            </div>

                            <div class="about-row">
                                <div class="text-2xl text-gray-400">📡</div>
                                <div>
                                    <div class="text-[#1c1e21] text-[15px]">Se unió en {{ $user->created_at->format('F \d\e Y') }}</div>
                                    <div class="text-[#65676b] text-[13px]">Larabook</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="text-[11px] text-[#90949c] mt-2">
                Privacidad · Condiciones · Publicidad · Cookies · Larabook © {{ date('Y') }}
            </div>

        </div>
    </div>
@endsection