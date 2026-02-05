@extends('layouts.app')

@section('title', 'Acceso denegado | Larabook')

@section('content')
<div class="flex justify-center pt-[50px] pb-[100px]">
    <div class="w-[600px] text-center">
        
        <div class="mb-6 flex justify-center">
            <svg class="w-[100px] h-[100px] text-[#bec2c9]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
            </svg>
        </div>

        <h2 class="text-[20px] font-bold text-[#1d2129] mb-2">
            Acceso restringido
        </h2>

        <p class="text-[#65676b] text-[15px] mb-6 px-8">
            No tienes permiso para ver esta página. Es posible que pertenezca a un grupo privado o que solo el propietario pueda verla.
        </p>

        <a href="{{ route('dashboard') }}" class="inline-block bg-[#4267b2] hover:bg-[#365899] text-white font-bold py-2 px-6 rounded-[2px] border border-[#4267b2] text-[14px]">
            Volver al Inicio
        </a>
        
        <div class="mt-6 text-[13px]">
            <a href="javascript:history.back()" class="text-[#365899] hover:underline font-semibold">Regresar</a>
        </div>
    </div>
</div>
@endsection