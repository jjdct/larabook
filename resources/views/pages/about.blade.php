@extends('layouts.app')
@section('title', 'Info de ' . $page->name)

@section('content')
    @include('pages.partials.header', ['active' => 'about'])

    <div class="max-w-[851px] mx-auto mt-4 pb-20">
        <div class="bg-white border border-[#dddfe2] rounded-sm min-h-[400px] p-4">
            <h2 class="text-[20px] font-bold text-[#1c1e21] border-b pb-4 mb-4">Información</h2>
            
            <div class="space-y-4">
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-bold text-gray-500">Categoría</div>
                    <div class="w-2/3">{{ $page->category }}</div>
                </div>
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-bold text-gray-500">Nombre</div>
                    <div class="w-2/3">{{ $page->name }}</div>
                </div>
                @if($page->website)
                <div class="flex border-b pb-2">
                    <div class="w-1/3 font-bold text-gray-500">Web</div>
                    <div class="w-2/3 text-blue-600">{{ $page->website }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection