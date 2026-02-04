@extends('layouts.app')

@section('title', 'Amigos | Larabook')

@push('styles')
<style>
    /* Estilos para el sidebar izquierdo tipo "Configuración" */
    .friends-sidebar-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px; border-radius: 5px; cursor: pointer;
        font-weight: bold; color: #4b4f56; font-size: 14px;
    }
    .friends-sidebar-item:hover { background-color: #f0f2f5; }
    .friends-sidebar-item.active { background-color: #e7f3ff; color: #1877f2; }

    /* Tarjetas de Amigos (Grid) */
    .friend-card {
        background: white;
        border: 1px solid #dddfe2;
        border-radius: 5px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .friend-card-img {
        width: 100%;
        height: 200px; /* Cuadrado visual */
        object-fit: cover;
        cursor: pointer;
    }
    .friend-card-body { padding: 12px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
    .friend-name { font-weight: bold; font-size: 16px; color: #1c1e21; margin-bottom: 5px; cursor: pointer; }
    .friend-name:hover { text-decoration: underline; }
    .friend-mutual { font-size: 13px; color: #65676b; margin-bottom: 10px; }
    
    .btn-full { width: 100%; font-weight: bold; font-size: 14px; padding: 6px 0; border-radius: 4px; margin-top: 5px; cursor: pointer; }
    .btn-primary { background: #e7f3ff; color: #1877f2; border: none; } /* Azul claro moderno */
    .btn-primary:hover { background: #dbe7f2; }
    .btn-confirm { background: #1877f2; color: white; border: none; }
    .btn-confirm:hover { background: #166fe5; }
    .btn-secondary { background: #e4e6eb; color: #050505; border: none; }
    .btn-secondary:hover { background: #d8dadf; }
</style>
@endpush

@section('content')
<div class="flex gap-6 pt-4">

    <div class="w-[300px] hidden md:block">
        <div class="text-2xl font-bold mb-4 px-2">Amigos</div>
        
        <div class="friends-sidebar-item active">
            <span>Inicio</span>
        </div>
        <div class="friends-sidebar-item">
            <span>Solicitudes de amistad</span>
            @if($requests->count() > 0)
                <span class="text-red-500 font-bold ml-auto pl-2">{{ $requests->count() }}</span>
                <span class="ml-1 text-[#1877f2]">›</span>
            @endif
        </div>
        <div class="friends-sidebar-item">
            <span>Sugerencias</span>
            <span class="ml-auto text-[#1877f2]">›</span>
        </div>
        <div class="friends-sidebar-item">
            <span>Todos los amigos</span>
            <span class="ml-auto text-[#1877f2]">›</span>
        </div>
        <div class="friends-sidebar-item">
            <span>Cumpleaños</span>
        </div>
        <div class="friends-sidebar-item">
            <span>Listas personalizadas</span>
        </div>
    </div>

    <div class="flex-grow max-w-[850px]">

        @if($requests->isNotEmpty())
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Solicitudes de amistad</h2>
                <a href="#" class="text-[#1877f2] text-sm hover:underline">Ver todas</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mb-8">
                @foreach($requests as $requestUser)
                    <div class="friend-card">
                        <a href="{{ route('profile.show', $requestUser->username) }}">
                            <img src="{{ $requestUser->avatar }}" class="friend-card-img">
                        </a>
                        <div class="friend-card-body">
                            <div>
                                <div class="friend-name">{{ $requestUser->name }}</div>
                                <div class="friend-mutual">1 amigo en común</div>
                            </div>
                            <div>
                                <form action="{{ route('friend.accept', $requestUser) }}" method="POST">
                                    @csrf
                                    <button class="btn-full btn-confirm mb-2">Confirmar</button>
                                </form>
                                <form action="{{ route('friend.reject', $requestUser) }}" method="POST">
                                    @csrf
                                    <button class="btn-full btn-secondary">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="border-b border-[#dddfe2] my-6"></div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Personas que quizá conozcas</h2>
            <a href="#" class="text-[#1877f2] text-sm hover:underline">Ver todas</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($suggestions as $suggestedUser)
                <div class="friend-card">
                    <a href="{{ route('profile.show', $suggestedUser->username) }}">
                        <img src="{{ $suggestedUser->avatar }}" class="friend-card-img bg-gray-100">
                    </a>
                    <div class="friend-card-body">
                        <div>
                            <a href="{{ route('profile.show', $suggestedUser->username) }}" class="friend-name block truncate">
                                {{ $suggestedUser->name }}
                            </a>
                            <div class="friend-mutual">
                                @if(rand(0,1)) {{ rand(1, 15) }} amigos en común
                                @else Nuevo en Larabook
                                @endif
                            </div>
                        </div>
                        
                        <form action="{{ route('friend.add', $suggestedUser) }}" method="POST">
                            @csrf
                            <button class="btn-full btn-primary text-[#1877f2] bg-[#e7f3ff]">Agregar a amigos</button>
                        </form>
                    </div>
                </div>
            @endforeach

            @if($suggestions->isEmpty())
                <div class="col-span-4 p-8 text-center text-gray-500 bg-white rounded border border-gray-200">
                    <div class="text-2xl mb-2">🤷‍♂️</div>
                    No hay más sugerencias por ahora.
                    <div class="text-sm">¡Invita a tus amigos reales a unirse a Larabook!</div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection