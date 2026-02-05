@extends('layouts.app')

@section('title', 'Publicación de ' . $post->author->name . ' | Larabook')

@section('content')
<div class="flex justify-center pt-6 pb-20">
    <div class="w-full max-w-[700px]">
        
        <div class="mb-4">
            <a href="javascript:history.back()" class="text-[#1877f2] font-bold text-sm hover:underline flex items-center gap-1">
                ← Volver al feed
            </a>
        </div>

        <x-post-card :post="$post" />

    </div>
</div>
@endsection