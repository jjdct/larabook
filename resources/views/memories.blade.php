@extends('layouts.app')

@section('title', 'Recuerdos | Larabook')

@push('styles')
<style>
    .memories-hero {
        background: url('https://static.xx.fbcdn.net/rsrc.php/v3/yC/r/o8p2J8s0Mw6.png') bottom repeat-x, linear-gradient(to bottom, #4267b2, #5a7bc2);
        height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-top: -16px; /* Para pegarse al navbar */
        position: relative;
    }
    
    .memories-content {
        max-width: 600px;
        margin: -50px auto 0; /* Subir para solapar el banner */
        position: relative;
        z-index: 2;
    }
</style>
@endpush

@section('content')

<div class="w-full bg-[#f0f2f5]">
    <div class="memories-hero">
        <h1 class="text-3xl font-bold mb-2">Un día como hoy</h1>
        <p class="text-lg opacity-90">Esperamos que te guste recordar este momento de tu historia.</p>
    </div>

    <div class="memories-content pb-20">
        
        <div class="card overflow-hidden">
            <div class="p-4 border-b border-[#e9eaed]">
                <div class="text-[#65676b] font-bold text-sm uppercase tracking-wide">Hace 1 año</div>
                <div class="text-[#050505] font-bold text-xl mt-1">Viste esto y pensaste en compartirlo</div>
            </div>

            <div class="p-4">
                <div class="flex gap-2 mb-3">
                    <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full border border-black/10">
                    <div>
                        <div class="text-[#050505] font-bold text-[14px]">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="text-[#65676b] text-[12px]">2 de febrero de 2025 · 🌎</div>
                    </div>
                </div>

                <div class="text-[14px] text-[#1c1e21] mb-3">
                    Intentando instalar Arch Linux por primera vez. Si no vuelvo a escribir en 2 horas, llamen a los bomberos. 🔥🐧 #Linux #Arch #Pain
                </div>

                <div class="rounded-lg overflow-hidden border border-[#dddfe2]">
                    <img src="https://miro.medium.com/v2/resize:fit:1400/1*F8K_GgY0jZg8o6_VdJ0w8Q.png" class="w-full object-cover">
                </div>
            </div>

            <div class="p-3 bg-[#f5f6f7] border-t border-[#dddfe2]">
                <button class="w-full bg-[#e7f3ff] hover:bg-[#dbe7f2] text-[#1877f2] font-bold py-2 rounded-md transition">
                    ↗️ Compartir
                </button>
            </div>
        </div>

        <div class="card p-4 mt-4 flex items-center justify-between">
            <div>
                <div class="text-[#65676b] text-xs font-bold uppercase mb-1">Amigos desde hace 2 años</div>
                <div class="font-bold text-lg">Te hiciste amigo de Mark Zuckerberg</div>
            </div>
            <img src="https://ui-avatars.com/api/?name=Mark+Zuckerberg" class="w-14 h-14 rounded-full border-2 border-white shadow-sm">
        </div>

    </div>
</div>

@endsection