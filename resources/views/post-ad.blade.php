@extends('layouts.app')

@section('title', 'Publicidad | Larabook')

@push('styles')
    <style>
        .btn-action-feed { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 6px 0; border-radius: 4px; color: #65676b; font-weight: 600; font-size: 14px; cursor: pointer; transition: background-color 0.1s; background: transparent; border: none; }
        .btn-action-feed:hover { background-color: #f0f2f5; }
    </style>
@endpush

@section('content')
<div class="flex justify-center pb-20 pt-4">
    <div class="w-full max-w-[590px]">

        <div class="bg-white border border-[#dddfe2] rounded-[3px] shadow-sm mb-4 relative">
            
            <div class="p-3 flex items-center gap-2 mb-1">
                <a href="#">
                    <img src="https://ui-avatars.com/api/?name=Jasper&background=ff2d20&color=fff" class="w-10 h-10 rounded-full border border-black/10">
                </a>
                <div>
                    <div class="leading-4">
                        <a href="#" class="font-bold text-[#050505] hover:underline text-[15px]">Jasper AI</a>
                    </div>
                    <div class="text-[13px] text-[#65676b] flex items-center gap-1 mt-0.5 group cursor-pointer">
                        <span class="font-normal text-[#65676b]">Publicidad</span>
                        <span>·</span>
                        <svg class="w-3 h-3 fill-[#65676b]" viewBox="0 0 16 16"><path d="M8 0a8 8 0 100 16A8 8 0 008 0zM2.5 8a5.5 5.5 0 018.25-4.76l.44.26-.5.87-.44-.26A4.5 4.5 0 003.5 8c0 1.95 1.23 3.6 3 4.24v1.07A5.5 5.5 0 012.5 8zm8.68 4.2l.44.25A5.5 5.5 0 0013.5 8a5.5 5.5 0 00-2.3-4.52l-.4.26.5.87.4-.26A4.5 4.5 0 0112.5 8a4.5 4.5 0 01-1.32 3.2z"/></svg>
                    </div>
                </div>
                
                <div class="ml-auto">
                    <button class="border border-[#ced0d4] text-[#4b4f56] font-bold text-sm px-3 py-1 rounded hover:bg-[#f2f2f2] transition">
                        Registrarte
                    </button>
                </div>
            </div>

            <div class="px-3 pb-3">
                <p class="text-[15px] text-[#050505] font-normal mb-2">
                    Deja de escribir código repetitivo. Deja que la IA escriba tus tests y documentación en segundos. 🤖✨
                </p>
            </div>
            
            <a href="#" class="block group">
                <div class="w-full bg-gray-100 overflow-hidden border-t border-[#dddfe2]">
                    <img src="https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?q=80&w=1000" class="w-full h-auto object-cover max-h-[600px] group-hover:opacity-95">
                </div>
                <div class="bg-[#f0f2f5] p-3 border-b border-[#dddfe2]">
                    <div class="text-[12px] text-[#606770] uppercase tracking-wide truncate">JASPER.AI</div>
                    <div class="text-[16px] text-[#1d2129] font-bold truncate leading-tight mt-0.5 group-hover:underline">
                        Jasper: Tu copiloto de inteligencia artificial
                    </div>
                    <div class="text-[14px] text-[#606770] truncate mt-1">
                        Escribe mejor, más rápido y creativo con el poder de GPT-4.
                    </div>
                </div>
            </a>

            <div class="mx-3 border-t border-[#ced0d4] py-1 flex mt-2">
                <button class="btn-action-feed">👍 Me gusta</button>
                <button class="btn-action-feed">💬 Comentar</button>
                <button class="btn-action-feed">↗️ Compartir</button>
            </div>

        </div>
    </div>
</div>
@endsection