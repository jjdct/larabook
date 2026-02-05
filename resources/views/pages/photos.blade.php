@extends('layouts.app')
@section('title', 'Fotos de ' . $page->name)

@section('content')
    @include('pages.partials.header', ['active' => 'photos'])

    <div class="max-w-[851px] mx-auto mt-4 pb-20">
        <div class="bg-white border border-[#dddfe2] rounded-sm min-h-[400px] p-4">
            <h2 class="text-[20px] font-bold text-[#1c1e21] border-b pb-4 mb-4">Fotos</h2>
            
            {{-- Lógica rápida de recolección de fotos --}}
            @php
                $photos = collect();
                // Agregar avatar y cover
                $photos->push(['url' => $page->avatar, 'id' => null]);
                $photos->push(['url' => $page->cover, 'id' => null]);
                
                foreach($page->posts as $post) {
                    if(!empty($post->attachments)) {
                        foreach($post->attachments as $img) {
                            $photos->push(['url' => Storage::url($img), 'id' => $post->id]);
                        }
                    }
                }
            @endphp

            <div class="grid grid-cols-4 gap-1">
                @foreach($photos as $photo)
                    <div class="relative aspect-square bg-gray-100 overflow-hidden border">
                        <img src="{{ $photo['url'] }}" class="w-full h-full object-cover hover:scale-105 transition">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection