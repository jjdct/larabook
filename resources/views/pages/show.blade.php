@extends('layouts.app')

@section('title', $page->name . ' | Larabook')

@push('styles')
<style>
    .page-header-container { background: white; border-bottom: 1px solid #d3d6db; }
    
    .cta-btn {
        padding: 6px 12px;
        font-weight: bold;
        font-size: 13px;
        border-radius: 2px;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }
    .btn-blue { background-color: #4267b2; color: white; border: 1px solid #4267b2; }
    .btn-gray { background-color: #f5f6f7; color: #4b4f56; border: 1px solid #ccd0d5; }
</style>
@endpush

@section('content')

    <div class="page-header-container shadow-sm mb-4 -mt-4 bg-white">
        <div class="max-w-[851px] mx-auto relative h-[360px]">
            
            <div class="h-[315px] w-full bg-gray-800 relative overflow-hidden group cursor-pointer">
                <img src="{{ $page->cover }}" class="w-full h-full object-cover">
                
                <div class="absolute bottom-4 left-[200px]">
                    <h1 class="text-white text-[30px] font-bold text-shadow drop-shadow-md flex items-center">
                        {{ $page->name }}
                        @if($page->is_verified)
                            <span class="text-[#1877f2] bg-white rounded-full w-5 h-5 flex items-center justify-center text-[12px] ml-2" title="Verificado">✓</span>
                        @endif
                    </h1>
                    <div class="text-white text-sm opacity-90 font-normal">{{ '@' . $page->username }}</div>
                </div>
            </div>

            <div class="absolute top-[230px] left-[15px] z-10">
                <div class="w-[160px] h-[160px] bg-white p-1 rounded-[2px] border border-gray-300">
                     <img src="{{ $page->avatar }}" class="w-full h-full object-cover border border-black/10 bg-gray-50">
                </div>
            </div>

            <div class="h-[45px] pl-[190px] flex items-center justify-between border-b border-[#d3d6db] bg-white">
                <div class="flex h-full">
                    <div class="px-4 h-full flex items-center font-bold text-[#4b4f56] border-b-2 border-[#4267b2] cursor-pointer">Inicio</div>
                    <div class="px-4 h-full flex items-center font-bold text-[#4b4f56] text-sm cursor-pointer hover:bg-gray-50">Información</div>
                    <div class="px-4 h-full flex items-center font-bold text-[#4b4f56] text-sm cursor-pointer hover:bg-gray-50">Fotos</div>
                </div>

                <div class="flex gap-2 pr-4">
                    @if(Auth::check() && Auth::id() === $page->user_id)
                        <button class="cta-btn btn-gray">✏️ Editar página</button>
                    @else
                        <button class="cta-btn btn-gray">👍 Te gusta</button>
                        <button class="cta-btn btn-blue">💬 Enviar mensaje</button>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="max-w-[851px] mx-auto flex gap-3 pb-20">

        <div class="w-[306px] space-y-3">
            <div class="card p-3">
                <div class="font-bold text-[#4b4f56] text-[16px] border-b border-[#e9eaed] pb-2 mb-2">Información</div>
                
                <div class="py-2 text-[13px] text-[#1d2129]">
                    <div class="flex gap-3 mb-2">
                        <span class="text-gray-400">ℹ️</span>
                        <span>{{ $page->category }}</span>
                    </div>
                    
                    @if($page->description)
                    <div class="flex gap-3 mb-2">
                        <span class="text-gray-400">📄</span>
                        <span>{{ Str::limit($page->description, 100) }}</span>
                    </div>
                    @endif

                    @if($page->location)
                    <div class="flex gap-3 mb-2">
                        <span class="text-gray-400">📍</span>
                        <span>{{ $page->location }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="w-[533px]">
            <div class="card p-4 text-center text-gray-500">
                <div class="text-lg font-bold mb-1">Aún no hay publicaciones</div>
                <p class="text-sm">Esta página es muy nueva.</p>
            </div>
        </div>

    </div>

@endsection