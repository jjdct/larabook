@extends('layouts.app')

@section('title', $group->name . ' | Larabook')

@push('styles')
<style>
    .group-cover { height: 350px; width: 100%; position: relative; border-bottom: 1px solid #d3d6db; }
    .group-nav-item { padding: 0 15px; height: 50px; line-height: 50px; color: #4b4f56; font-weight: bold; font-size: 14px; cursor: pointer; border-bottom: 3px solid transparent; }
    .group-nav-item.active { color: #4267b2; border-bottom: 3px solid #4267b2; }
</style>
@endpush

@section('content')

    <div class="bg-white shadow-sm mb-4 -mt-4">
        <div class="max-w-[1012px] mx-auto">
            
            <div class="group-cover overflow-hidden bg-gray-200">
                <img src="{{ $group->cover }}" class="w-full h-full object-cover">
            </div>

            <div class="max-w-[851px] mx-auto pt-4 px-4 bg-white border-b border-[#d3d6db]">
                <h1 class="text-[28px] font-bold text-[#1c1e21] leading-tight">{{ $group->name }}</h1>
                
                <div class="text-[13px] text-[#606770] flex items-center gap-2 mt-1 mb-4">
                    @if($group->privacy === 'public') <span>🌎 Grupo Público</span>
                    @elseif($group->privacy === 'closed') <span>🔒 Grupo Cerrado</span>
                    @else <span>👁️ Grupo Secreto</span>
                    @endif
                    <span>· {{ $group->members->count() }} miembro(s)</span>
                </div>

                <div class="flex items-center justify-between border-t border-[#e9eaed]">
                    <div class="flex h-full">
                        <div class="group-nav-item active">Conversación</div>
                        <div class="group-nav-item">Miembros</div>
                        <div class="group-nav-item">Eventos</div>
                    </div>
                    
                    <div class="py-2">
                         @if($group->members->contains(Auth::user()))
                            <button class="bg-[#e9ebee] text-[#4b4f56] font-bold px-3 py-1.5 rounded-[2px] border border-[#ccd0d5] text-sm">
                                ✓ Eres miembro
                            </button>
                        @else
                            <button class="bg-[#42b72a] hover:bg-[#36a420] text-white font-bold px-4 py-1.5 rounded-[2px] border border-[#36a420] text-sm">
                                + Unirte al grupo
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="max-w-[851px] mx-auto flex gap-3 pb-20">
        <div class="w-[533px]">
            <div class="card p-4 text-center text-gray-500">
                Aún no hay publicaciones en este grupo. ¡Sé el primero!
            </div>
        </div>

        <div class="w-[306px]">
            <div class="card p-3">
                <div class="font-bold text-[#1c1e21] mb-2 text-[16px]">Acerca de</div>
                <div class="text-[13px] text-[#1d2129] mb-2">
                    {{ $group->description ?? 'Sin descripción.' }}
                </div>
            </div>
        </div>
    </div>

@endsection