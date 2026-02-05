@extends('layouts.app')

@section('title', 'Registro de actividad | Larabook')

@push('styles')
<style>
    /* === REUTILIZAMOS ESTILOS DE CABECERA === */
    .cover-gradient { background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 20%); }
    .hidden-input { display: none; }
    
    /* === ESTILOS ACTIVITY LOG === */
    .log-sidebar-item {
        padding: 8px 10px; font-size: 13px; color: #1c1e21; cursor: pointer; border-radius: 2px; display: flex; align-items: center; gap: 10px;
    }
    .log-sidebar-item:hover { background-color: #f5f6f7; }
    .log-sidebar-item.active { font-weight: bold; background-color: #e4e6eb; }
    
    .log-date-header {
        font-weight: bold; font-size: 13px; color: #65676b; text-transform: uppercase; margin: 20px 0 10px 0;
    }
    
    .log-item {
        background: white; border: 1px solid #dddfe2; border-radius: 3px; margin-bottom: -1px; /* Colapsar bordes */
        display: flex; padding: 12px; align-items: flex-start;
    }
    .log-item:first-child { border-top-left-radius: 3px; border-top-right-radius: 3px; }
    .log-item:last-child { border-bottom-left-radius: 3px; border-bottom-right-radius: 3px; margin-bottom: 15px; }
    
    .log-icon {
        width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        background: #f0f2f5; margin-right: 12px; flex-shrink: 0; font-size: 18px;
    }
    .log-content { flex-grow: 1; font-size: 14px; }
    .log-meta { font-size: 12px; color: #65676b; margin-top: 2px; }
    .log-action { margin-left: 10px; cursor: pointer; color: #65676b; }
    .log-action:hover { color: #1c1e21; }
</style>
@endpush

@section('content')
    <div class="-mt-4"> 
        
        <div class="bg-white border-b border-[#d3d6db] shadow-sm mb-4">
            <div class="max-w-[851px] mx-auto relative h-[315px] bg-gray-300 overflow-hidden group">
                 @if($user->cover) <img src="{{ $user->cover }}" class="w-full h-full object-cover object-center">
                 @else <div class="w-full h-full bg-gray-400 flex items-center justify-center text-gray-500 font-bold">Sin portada</div> @endif
                 <div class="absolute bottom-0 left-0 w-full h-[100px] cover-gradient"></div>
                 
                 <h1 class="absolute bottom-[20px] left-[180px] text-white text-[30px] font-bold text-shadow drop-shadow-md flex items-center z-10">
                    {{ $user->name }}
                 </h1>
                 
                 <div class="absolute bottom-[20px] right-[20px] z-10">
                     <a href="{{ route('profile.show', $user->username) }}" class="bg-white text-[#1c1e21] px-4 py-2 rounded font-bold text-sm hover:bg-gray-100">
                        Volver al perfil
                     </a>
                 </div>

                 <div class="absolute top-[160px] left-[15px] p-1 bg-white rounded-full border border-[rgba(0,0,0,.1)] z-10">
                    <img src="{{ $user->avatar }}" class="w-[160px] h-[160px] rounded-full object-cover border border-[rgba(0,0,0,.1)] bg-white relative z-10">
                </div>
            </div>
            <div class="max-w-[851px] mx-auto h-[20px]"></div>
        </div>

        <div class="max-w-[851px] mx-auto flex gap-4 pb-20 mt-10">
            
            <div class="w-[200px] flex-shrink-0">
                <div class="font-bold text-xl mb-4 text-[#1c1e21]">Registro de actividad</div>
                
                <div class="log-sidebar-item active">
                    <span>🛡️</span> Todo
                </div>
                <div class="log-sidebar-item">
                    <span>📝</span> Tus publicaciones
                </div>
                <div class="log-sidebar-item">
                    <span>🏷️</span> Etiquetas
                </div>
                <div class="log-sidebar-item">
                    <span>💬</span> Comentarios
                </div>
                <div class="log-sidebar-item">
                    <span>👍</span> Me gusta y reacciones
                </div>
                <div class="log-sidebar-item">
                    <span>👥</span> Amigos agregados
                </div>
            </div>

            <div class="flex-grow">
                
                @php
                    // En un controlador real, esto sería una query compleja.
                    // Aquí mezclamos tus posts y comentarios manualmente para simular el log.
                    $activities = collect();

                    // 1. Agregar Posts
                    foreach($user->posts as $post) {
                        $activities->push([
                            'type' => 'post',
                            'icon' => '✏️',
                            'text' => 'publicó en su muro.',
                            'content' => Str::limit($post->content, 60),
                            'date' => $post->created_at
                        ]);
                    }

                    // 2. Agregar Comentarios
                    foreach($user->comments as $comment) {
                        $activities->push([
                            'type' => 'comment',
                            'icon' => '💬',
                            'text' => 'comentó en una publicación.',
                            'content' => Str::limit($comment->content, 60),
                            'date' => $comment->created_at
                        ]);
                    }

                    // Ordenar por fecha descendente
                    $activities = $activities->sortByDesc('date');
                    $currentMonth = null;
                @endphp

                @if($activities->isEmpty())
                    <div class="bg-white p-8 border border-gray-200 rounded text-center text-gray-500">
                        No hay actividad reciente.
                    </div>
                @else
                    @foreach($activities as $activity)
                        
                        @php 
                            $monthName = $activity['date']->translatedFormat('F Y');
                        @endphp

                        @if($currentMonth !== $monthName)
                            <div class="log-date-header">{{ $monthName }}</div>
                            @php $currentMonth = $monthName; @endphp
                        @endif

                        <div class="log-item group">
                            <div class="log-icon">{{ $activity['icon'] }}</div>
                            <div class="log-content">
                                <div>
                                    <span class="font-bold text-[#1c1e21]">{{ $user->first_name }}</span>
                                    {{ $activity['text'] }}
                                </div>
                                @if($activity['content'])
                                    <div class="text-gray-500 italic mt-1">"{{ $activity['content'] }}"</div>
                                @endif
                                <div class="log-meta">
                                    {{ $activity['date']->format('d \d\e F, H:i') }} · 
                                    @if($activity['type'] == 'post') 🌎 Público @else 👥 Amigos @endif
                                </div>
                            </div>
                            <div class="log-action opacity-0 group-hover:opacity-100 transition" title="Ocultar del perfil">
                                🚫
                            </div>
                            <div class="log-action opacity-0 group-hover:opacity-100 transition" title="Eliminar">
                                🗑️
                            </div>
                        </div>

                    @endforeach
                @endif

            </div>

        </div>
    </div>
@endsection