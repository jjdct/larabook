@extends('layouts.app')
@section('title', $page->name)

@section('content')
    {{-- Incluimos el header parcial pasando 'home' como activo --}}
    @include('pages.partials.header', ['active' => 'home'])

    <div class="max-w-[851px] mx-auto flex gap-3 pb-20">
        <div class="w-[306px] space-y-3">
            <div class="card p-3">
                <div class="font-bold text-[#4b4f56] border-b border-[#e9eaed] pb-2 mb-2">Información</div>
                <div class="text-[13px] text-[#1d2129] space-y-2">
                    <div>ℹ️ {{ $page->category }}</div>
                    @if($page->description) <div>📄 {{ Str::limit($page->description, 80) }}</div> @endif
                </div>
            </div>
            
            <div class="card p-3">
                 <div class="font-bold text-[#4b4f56] text-[16px] border-b border-[#e9eaed] pb-2 mb-2">Fotos</div>
                 <div class="text-center text-gray-400 text-xs py-2">Ver todas</div>
            </div>
        </div>

        <div class="w-[533px]">
            
            {{-- Lógica para mostrar caja de posts solo a Admin REAL y no en modo visitante --}}
            @php
                $isAdmin = Auth::check() && Auth::id() === $page->user_id;
                $isViewingAsVisitor = request('view_as') === 'visitor';
            @endphp

            @if($isAdmin && !$isViewingAsVisitor)
            <div class="card p-3 mb-4" x-data="{ hasImage: false, fileName: '' }">
                <div class="flex gap-2 border-b border-[#e9eaed] pb-3 text-[12px] font-bold text-[#4b4f56]">
                    <div class="px-2 py-1 bg-[#f5f6f7] rounded cursor-pointer flex items-center gap-1">
                        ✏️ Crear publicación
                    </div>
                    
                    <label for="page_post_upload" class="px-2 py-1 hover:bg-[#f5f6f7] rounded cursor-pointer flex items-center gap-1 transition select-none">
                        📷 Foto/video
                    </label>
                </div>

                <div class="flex gap-2 mt-3">
                    <img src="{{ $page->avatar }}" class="w-10 h-10 rounded-full border border-black/10 object-cover">
                    
                    <form action="{{ route('pages.post.store', $page->username) }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="flex-grow"> 
                        @csrf
                        
                        <div class="w-full">
                            <input type="text" 
                                   name="content" 
                                   class="w-full border-none focus:ring-0 text-sm placeholder-gray-500" 
                                   placeholder="Publicar como {{ $page->name }}..." 
                                   autocomplete="off">
                            
                            <input type="file" 
                                   name="image" 
                                   id="page_post_upload" 
                                   class="hidden" 
                                   accept="image/*"
                                   @change="hasImage = true; fileName = $event.target.files[0].name">
                        </div>

                        <div x-show="hasImage" x-transition class="mt-2 text-xs text-green-600 bg-green-50 p-1.5 rounded border border-green-200 flex items-center gap-2" style="display: none;">
                            <span class="text-lg">🖼️</span>
                            <span class="font-semibold">Imagen seleccionada:</span>
                            <span x-text="fileName" class="truncate max-w-[200px] italic text-gray-600"></span>
                            
                            <button type="button" 
                                    @click="hasImage = false; fileName = ''; document.getElementById('page_post_upload').value = ''" 
                                    class="ml-auto text-red-500 hover:text-red-700 font-bold px-2 hover:bg-red-50 rounded">
                                ✕
                            </button>
                        </div>

                        <div class="flex justify-end border-t border-[#e9eaed] pt-2 mt-2">
                            <button type="submit" class="bg-[#1877f2] hover:bg-[#166fe5] text-white px-4 py-1 rounded font-bold text-xs transition">
                                Publicar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- LISTA DE POSTS --}}
            @forelse($page->posts as $post)
                <x-post-card :post="$post" />
            @empty
                <div class="card p-6 text-center text-gray-500">
                    <div class="text-3xl mb-2">📢</div>
                    <div class="font-bold text-lg">Aún no hay publicaciones</div>
                    <div class="text-sm">¡Estrena el muro de tu página!</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection