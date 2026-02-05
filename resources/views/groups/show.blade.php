@extends('layouts.app')

@section('title', $group->name . ' | Larabook')

@push('styles')
<style>
    .group-header { background: white; border-bottom: 1px solid #d3d6db; }
    .group-cover { height: 350px; width: 100%; position: relative; background-color: #333; overflow: hidden; }
    .group-cover img { width: 100%; height: 100%; object-fit: cover; }
    
    .group-nav-item { padding: 0 16px; height: 50px; display: flex; align-items: center; font-weight: 600; color: #65676b; cursor: pointer; border-bottom: 3px solid transparent; }
    .group-nav-item:hover { background-color: #f2f2f2; }
    .group-nav-item.active { color: #1877f2; border-bottom-color: #1877f2; }

    .btn-action { padding: 8px 12px; border-radius: 6px; font-weight: 600; font-size: 15px; display: flex; align-items: center; gap: 6px; }
    .btn-blue { background: #1877f2; color: white; }
    .btn-gray { background: #e4e6eb; color: #050505; }
</style>
@endpush

@section('content')

    <div class="group-header shadow-sm mb-4 -mt-4">
        <div class="max-w-[1095px] mx-auto bg-white rounded-b-lg">
            
            <div class="group-cover rounded-b-lg">
                <img src="{{ $group->cover }}">
                
                <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/60 to-transparent p-6 pt-20">
                    <h1 class="text-white text-3xl font-bold drop-shadow-md">{{ $group->name }}</h1>
                    <div class="text-white/90 text-sm font-semibold flex items-center gap-2 mt-1">
                        @if($group->privacy === 'private') 🔒 Grupo Privado @else 🌎 Grupo Público @endif
                        <span>·</span>
                        <span>{{ $group->members->count() }} miembros</span>
                    </div>
                </div>
            </div>

            <div class="px-4 flex items-center justify-between">
                <div class="flex">
                    <div class="group-nav-item active">Conversación</div>
                    <div class="group-nav-item">Destacados</div>
                    <div class="group-nav-item">Personas</div>
                    <div class="group-nav-item">Eventos</div>
                </div>
                
                <div class="flex gap-2 py-2">
                    <div class="relative group" x-data="{ open: false }">
                        <button @click="open = !open" class="btn-gray text-xs">
                            <img src="{{ Auth::user()->avatar }}" class="w-5 h-5 rounded-full">
                            <span>▼</span>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 top-full mt-1 w-48 bg-white shadow-lg rounded border border-gray-200 p-1 z-50" style="display: none;">
                            <div class="px-2 py-1 text-xs text-gray-500 font-bold">Interactuar como:</div>
                            <div class="flex items-center gap-2 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                <img src="{{ Auth::user()->avatar }}" class="w-6 h-6 rounded-full">
                                <span class="text-sm font-bold">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="border-t my-1"></div>
                            <div class="px-2 py-1 text-xs text-gray-500">Tus páginas</div>
                            <div class="p-2 text-xs text-gray-400 italic">No hay páginas vinculadas</div>
                        </div>
                    </div>

                    <button class="btn-blue">+ Invitar</button>
                    <button class="btn-gray">Unirte</button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[1095px] mx-auto flex gap-4 pb-20 px-4">
        
        <div class="w-[360px] flex-shrink-0 space-y-4 hidden md:block">
            <div class="card p-4">
                <div class="font-bold text-lg mb-2">Acerca de</div>
                <div class="text-sm text-gray-600 mb-4">
                    {{ $group->description ?? 'Bienvenido al grupo ' . $group->name . '. Comparte y conecta con la comunidad.' }}
                </div>
                
                <div class="flex items-center gap-2 mb-3 text-sm font-semibold">
                    <span class="text-lg">🌎</span>
                    <div>
                        <div>Público</div>
                        <div class="text-xs font-normal text-gray-500">Cualquiera puede ver quién pertenece al grupo y lo que se publica.</div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 mb-3 text-sm font-semibold">
                    <span class="text-lg">👁️</span>
                    <div>
                        <div>Visible</div>
                        <div class="text-xs font-normal text-gray-500">Cualquiera puede encontrar este grupo.</div>
                    </div>
                </div>
            </div>
            
            <div class="text-xs text-gray-400">
                Privacidad · Condiciones · Publicidad · Opciones de anuncios · Cookies · <br>
                Larabook © 2026
            </div>
        </div>

        <div class="flex-grow max-w-[680px]">
            
            <div class="card p-3 mb-4" x-data="{ hasImage: false, fileName: '' }">
                <div class="flex gap-3">
                    <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full border border-gray-200">
                    
                    <form action="{{ route('groups.post.store', $group->slug) }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="flex-grow bg-[#f0f2f5] rounded-2xl px-3 py-2 hover:bg-[#e4e6eb] transition cursor-pointer relative">
                        @csrf
                        
                        <input type="text" 
                               name="content" 
                               class="w-full bg-transparent border-none focus:ring-0 text-sm placeholder-gray-600 cursor-text" 
                               placeholder="Escribe algo..." 
                               autocomplete="off">

                        <input type="file" 
                               name="image" 
                               id="group_post_image" 
                               class="hidden" 
                               accept="image/*"
                               @change="hasImage = true; fileName = $event.target.files[0].name">

                        <div class="absolute right-2 top-1/2 -translate-y-1/2 flex gap-1">
                            <label for="group_post_image" class="text-gray-500 hover:bg-gray-200 p-1.5 rounded-full cursor-pointer transition" title="Foto/video">
                                📷
                            </label>
                        </div>
                    </form>
                </div>

                <div x-show="hasImage" x-transition class="mt-2 ml-[52px] text-xs text-green-600 flex items-center gap-2" style="display: none;">
                    <span class="font-bold">📎 Imagen:</span>
                    <span x-text="fileName" class="truncate max-w-[200px]"></span>
                    <button type="button" @click="hasImage = false; fileName = ''; document.getElementById('group_post_image').value = ''" class="text-red-500 font-bold hover:underline">Eliminar</button>
                </div>

                <div class="flex justify-end mt-2 pt-2 border-t border-gray-100">
                    <button onclick="this.closest('.card').querySelector('form').submit()" class="bg-[#1877f2] hover:bg-[#166fe5] text-white px-6 py-1 rounded font-bold text-xs transition">
                        Publicar
                    </button>
                </div>
            </div>

            @forelse($group->posts as $post)
                <x-post-card :post="$post" />
            @empty
                <div class="bg-white p-8 rounded-lg text-center text-gray-500 shadow border border-gray-200">
                    <div class="text-5xl mb-3">🏔️</div>
                    <h3 class="text-xl font-bold text-gray-700">El grupo está tranquilo... demasiado tranquilo.</h3>
                    <p class="text-sm mt-2">Sé el primero en publicar algo interesante.</p>
                </div>
            @endforelse

        </div>
    </div>

@endsection