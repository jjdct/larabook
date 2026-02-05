@extends('layouts.app')

@section('title', 'Error del servidor | Larabook')

@section('content')
<div class="flex justify-center pt-[50px] pb-[100px]">
    <div class="w-[600px] text-center">
        
        <div class="mb-6 flex justify-center">
            <svg class="w-[100px] h-[100px] text-[#bec2c9]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/>
            </svg>
        </div>

        <h2 class="text-[20px] font-bold text-[#1d2129] mb-2">
            Disculpa, algo salió mal
        </h2>

        <p class="text-[#65676b] text-[15px] mb-6 px-8">
            Estamos trabajando para arreglarlo lo antes posible. Intenta volver a cargar la página en unos minutos.
        </p>

        <a href="javascript:location.reload()" class="inline-block bg-[#4267b2] hover:bg-[#365899] text-white font-bold py-2 px-6 rounded-[2px] border border-[#4267b2] text-[14px]">
            Recargar página
        </a>
    </div>
</div>
@endsection