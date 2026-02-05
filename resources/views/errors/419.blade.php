@extends('layouts.app')

@section('title', 'Sesión caducada | Larabook')

@section('content')
<div class="flex justify-center pt-[50px] pb-[100px]">
    <div class="w-[600px] text-center">
        
        <div class="mb-6 flex justify-center">
            <svg class="w-[100px] h-[100px] text-[#bec2c9]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
            </svg>
        </div>

        <h2 class="text-[20px] font-bold text-[#1d2129] mb-2">
            La página ha caducado
        </h2>

        <p class="text-[#65676b] text-[15px] mb-6 px-8">
            Tu sesión ha expirado por inactividad o la página lleva mucho tiempo abierta. Por favor, recarga e inténtalo de nuevo.
        </p>

        <a href="javascript:location.reload()" class="inline-block bg-[#4267b2] hover:bg-[#365899] text-white font-bold py-2 px-6 rounded-[2px] border border-[#4267b2] text-[14px]">
            Actualizar
        </a>
    </div>
</div>
@endsection