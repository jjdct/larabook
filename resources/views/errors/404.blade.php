@extends('layouts.app')

@section('title', 'Página no encontrada | Larabook')

@section('content')
<div class="flex justify-center pt-[50px] pb-[100px]">
    <div class="w-[600px] text-center">
        
        <div class="mb-6 flex justify-center">
            <svg class="w-[100px] h-[100px] text-[#bec2c9]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19.35 10.04C21.95 10.22 23 11.73 23 13.95V19c0 3.31-2.69 6-6 6h-6c-2.09 0-3.96-1.02-5.19-2.66l-1.39-2.22c-.22-.35-.78-.47-1.12-.24-.35.23-.46.79-.22 1.14.07.1.1.22.1.34V22H1.5C.67 22 0 21.33 0 20.5v-7c0-.44.19-.84.49-1.12L6.15 6.72C6.98 5.89 7.49 4.8 7.6 3.65l.08-.85c.16-1.63 1.54-2.8 3.19-2.8 1.48 0 2.76.99 3.12 2.42L14.7 6h2.8c1.66 0 3 1.34 3 3 0 .4-.08.78-.23 1.13.03-.03.06-.06.08-.09z"/>
                <path class="text-white" d="M18 12l-4 4m0-4l4 4" stroke="#bec2c9" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </div>

        <h2 class="text-[20px] font-bold text-[#1d2129] mb-2">
            Esta página no está disponible
        </h2>

        <p class="text-[#65676b] text-[15px] mb-6 px-8">
            Es posible que el enlace que seleccionaste esté roto o que se haya eliminado la página.
        </p>

        <a href="{{ route('dashboard') }}" class="inline-block bg-[#4267b2] hover:bg-[#365899] text-white font-bold py-2 px-6 rounded-[2px] border border-[#4267b2] text-[14px]">
            Ir a la Sección de noticias
        </a>

        <div class="mt-6 text-[13px]">
            <a href="javascript:history.back()" class="text-[#365899] hover:underline font-semibold">Regresar</a>
            <span class="text-[#90949c] mx-1">·</span>
            <a href="#" class="text-[#365899] hover:underline font-semibold">Servicio de ayuda</a>
        </div>

    </div>
</div>
@endsection