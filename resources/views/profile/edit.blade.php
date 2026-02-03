@extends('layouts.app')

@section('title', 'Configuración general de la cuenta')

@push('styles')
<style>
    /* Estilos exclusivos de la página de Ajustes */
    .settings-nav-item { 
        display: block; 
        padding: 8px 10px; 
        color: #4b4f56; 
        font-size: 13px; 
        text-decoration: none; 
        border-radius: 2px; 
        margin-bottom: 2px;
    }
    .settings-nav-item:hover { background-color: #f5f6f7; }
    
    /* Estado Activo (Borde Rojo Clásico) */
    .settings-nav-item.active { 
        font-weight: bold; 
        color: #1c1e21; 
        background-color: #f5f6f7; 
        border-left: 3px solid #fa3e3e; 
    }
    
    /* Filas del Formulario */
    .fb-setting-row { 
        display: flex; 
        padding: 15px 0; 
        border-bottom: 1px solid #e5e5e5; 
        align-items: baseline; 
    }
    .fb-setting-label { 
        width: 150px; 
        font-weight: bold; 
        color: #90949c; 
        font-size: 13px; 
    }
    .fb-setting-content { 
        flex-grow: 1; 
        color: #1c1e21; 
        font-size: 13px; 
    }
    
    /* Input específico de settings (más compacto) */
    .setting-input { 
        border: 1px solid #ccd0d5; 
        padding: 4px 6px; 
        font-size: 13px; 
        width: 100%; 
        max-width: 300px; 
        color: #1c1e21;
    }
    .setting-input:focus { border-color: #1d4085; }
</style>
@endpush

@section('content')
    <div class="flex gap-5 mt-6">
        
        <div class="w-[220px] flex-shrink-0">
            <a href="#" class="settings-nav-item active">
                <span class="mr-2">⚙️</span> General
            </a>
            <a href="#" class="settings-nav-item">
                <span class="mr-2">🛡️</span> Seguridad e inicio de sesión
            </a>
            <a href="#" class="settings-nav-item">
                <span class="mr-2">🔒</span> Privacidad
            </a>
            <a href="#" class="settings-nav-item">
                <span class="mr-2">🚫</span> Bloqueos
            </a>
            <a href="#" class="settings-nav-item">
                <span class="mr-2">🔔</span> Notificaciones
            </a>
        </div>

        <div class="flex-grow bg-white border border-[#dddfe2] rounded p-5 min-h-[500px]">
            
            <h1 class="text-[20px] font-bold text-[#1c1e21] border-b border-[#dadde1] pb-3 mb-4">
                Configuración general de la cuenta
            </h1>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="fb-setting-row">
                    <div class="fb-setting-label">Nombre</div>
                    <div class="fb-setting-content">
                        <div class="flex gap-2 max-w-[300px]">
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="setting-input" placeholder="Nombre">
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="setting-input" placeholder="Apellido">
                        </div>
                        @error('first_name') <div class="text-[#dd3c10] text-xs mt-1">⚠️ {{ $message }}</div> @enderror
                        @error('last_name') <div class="text-[#dd3c10] text-xs mt-1">⚠️ {{ $message }}</div> @enderror
                    </div>
                    <div class="text-right w-[50px] text-[#385898] text-xs cursor-pointer hover:underline">Editar</div>
                </div>

                <div class="fb-setting-row">
                    <div class="fb-setting-label">Nombre de usuario</div>
                    <div class="fb-setting-content">
                        <div class="text-xs text-gray-500 mb-1">http://larabook.com/<strong>{{ $user->username }}</strong></div>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="setting-input">
                        @error('username') <div class="text-[#dd3c10] text-xs mt-1">⚠️ {{ $message }}</div> @enderror
                    </div>
                    <div class="text-right w-[50px] text-[#385898] text-xs cursor-pointer hover:underline">Editar</div>
                </div>

                <div class="fb-setting-row">
                    <div class="fb-setting-label">Contacto</div>
                    <div class="fb-setting-content">
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="setting-input">
                        @error('email') <div class="text-[#dd3c10] text-xs mt-1">⚠️ {{ $message }}</div> @enderror
                    </div>
                    <div class="text-right w-[50px] text-[#385898] text-xs cursor-pointer hover:underline">Editar</div>
                </div>

                <div class="fb-setting-row">
                    <div class="fb-setting-label">Biografía</div>
                    <div class="fb-setting-content">
                        <textarea name="bio" class="setting-input h-16 resize-none" placeholder="Escribe algo breve sobre ti...">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <div class="text-[#dd3c10] text-xs mt-1">⚠️ {{ $message }}</div> @enderror
                    </div>
                    <div class="text-right w-[50px] text-[#385898] text-xs cursor-pointer hover:underline">Editar</div>
                </div>

                <div class="mt-6 pt-4 border-t border-[#dadde1] text-right flex items-center justify-end gap-3">
                    @if (session('status') === 'profile-updated')
                        <span class="text-[#42b72a] text-sm font-bold animate-pulse">✓ Cambios guardados</span>
                    @endif
                    
                    <button type="submit" class="bg-[#4267b2] hover:bg-[#365899] text-white font-bold py-1.5 px-5 rounded-[2px] text-sm border border-[#29487d] shadow-sm cursor-pointer">
                        Guardar cambios
                    </button>
                </div>

            </form>
            
            <div class="mt-8 pt-4 border-t border-[#dadde1]">
                <a href="#" class="text-[#385898] text-sm hover:underline">Desactivar tu cuenta</a>
            </div>

        </div>
    </div>
@endsection
