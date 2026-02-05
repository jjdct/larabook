@props(['post'])

<div class="card mb-4" x-data="{ openMenu: false, showComments: false, showShareModal: false, shareType: 'profile' }">
    
    <div class="p-3">
        {{-- ================= HEADER DEL POST ================= --}}
        <div class="flex justify-between items-start">
            <div class="flex gap-2 mb-2">
                <a href="{{ route('profile.show', $post->author->username) }}">
                    <img src="{{ $post->author->avatar ?? 'https://ui-avatars.com/api/?name=X' }}" class="w-10 h-10 rounded-full border border-black/10 object-cover">
                </a>
                
                <div>
                    <div class="text-[#365899] font-bold text-sm leading-4 flex items-center flex-wrap">
                        <a href="{{ route('profile.show', $post->author->username) }}" class="cursor-pointer hover:underline">
                            {{ $post->author->name ?? 'Usuario' }}
                        </a>

                        {{-- Lógica de la flechita ▶ si es Grupo o Página --}}
                        @if($post->wall_type === 'App\Models\Group')
                            <span class="text-gray-500 font-normal mx-1 text-[10px]">▶</span>
                            <a href="{{ route('groups.show', $post->wall->slug) }}" class="hover:underline text-[#365899]">
                                {{ $post->wall->name }}
                            </a>
                        @elseif($post->wall_type === 'App\Models\Page' && $post->author_type !== 'App\Models\Page')
                            <span class="text-gray-500 font-normal mx-1 text-[10px]">▶</span>
                            <a href="{{ route('pages.show', $post->wall->username) }}" class="hover:underline text-[#365899]">
                                {{ $post->wall->name }}
                            </a>
                        @endif
                    </div>
                    
                    <a href="{{ route('post.show', $post) }}" class="text-[#90949c] text-[12px] mt-0.5 hover:underline cursor-pointer block">
                        {{ $post->created_at->diffForHumans() }} · 
                        @if($post->wall_type === 'App\Models\Group')
                            <span title="Grupo">👥</span>
                        @elseif($post->privacy == 'public') 
                            <span title="Público">🌎</span> 
                        @else 
                            <span title="Amigos">👥</span> 
                        @endif
                    </a>
                </div>
            </div>
            
            <div class="relative">
                <button @click="openMenu = !openMenu" @click.outside="openMenu = false" class="text-gray-400 hover:text-gray-600 font-bold px-2 text-xl pb-2">...</button>
                
                <div x-show="openMenu" class="post-menu" style="display:none; position: absolute; right: 0; top: 20px; background: white; border: 1px solid #dddfe2; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); z-index: 50; width: 200px; border-radius: 4px;">
                    <a href="{{ route('post.show', $post) }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        👁️ Ver publicación
                    </a>

                    <form action="#" method="POST"> @csrf
                        <button type="button" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            🔖 Guardar publicación
                        </button>
                    </form>

                    @if(Auth::id() === $post->user_id || Auth::id() === $post->wall_id)
                        <div class="border-t border-gray-200 my-1"></div>
                        {{-- Asegúrate de tener la ruta post.destroy --}}
                        <form action="{{ route('post.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Borrar permanentemente?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-gray-100 font-bold">
                                🗑️ Mover a la papelera
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- ================= CONTENIDO DEL POST ================= --}}
        <div class="text-[14px] text-[#1d2129] mb-2 whitespace-pre-line">{{ $post->content }}</div>

        @if(!empty($post->attachments) && is_array($post->attachments))
            <div class="mt-2 -mx-3">
                @if(count($post->attachments) === 1)
                    <img src="{{ Storage::url($post->attachments[0]) }}" class="w-full h-auto object-cover max-h-[500px] border-t border-b border-gray-100">
                @else
                    <div class="grid grid-cols-2 gap-1 border-t border-b border-gray-100">
                        @foreach($post->attachments as $img)
                            <img src="{{ Storage::url($img) }}" class="w-full h-48 object-cover">
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
        
        {{-- ================= ESTADÍSTICAS (Likes y Comentarios) ================= --}}
        @if($post->reactions->count() > 0 || $post->comments->count() > 0)
            <div class="flex justify-between items-center mt-2 text-[#65676b] text-[13px] border-b border-gray-100 pb-2">
                <div class="flex items-center gap-1">
                    @if($post->reactions->count() > 0)
                        <div class="flex -space-x-1">
                            <div class="w-4 h-4 rounded-full bg-blue-500 flex items-center justify-center border border-white text-[9px] text-white">👍</div>
                            @if($post->reactions->where('type', 'love')->count() > 0) 
                                <div class="w-4 h-4 rounded-full bg-red-500 flex items-center justify-center border border-white text-[9px] text-white">❤️</div> 
                            @endif
                        </div>
                        <span class="hover:underline cursor-pointer ml-1">{{ $post->reactions->count() }}</span>
                    @endif
                </div>

                @if($post->comments->count() > 0)
                    <div class="cursor-pointer hover:underline" @click="showComments = !showComments">
                        {{ $post->comments->count() }} comentarios
                    </div>
                @endif
            </div>
        @endif
    </div>
    
    {{-- ================= BARRA DE ACCIONES ================= --}}
    @php
        $myReaction = $post->isReactedBy(Auth::user());
        $colors = ['like'=>'text-blue-600','love'=>'text-red-500','haha'=>'text-yellow-500','sad'=>'text-yellow-500','angry'=>'text-orange-600'];
        $labels = ['like'=>'Me gusta','love'=>'Me encanta','haha'=>'Me divierte','sad'=>'Me entristece','angry'=>'Me enoja'];
        
        $currColor = $myReaction ? ($colors[$myReaction->type] ?? 'text-blue-600') : 'text-gray-500';
        $currText = $myReaction ? ($labels[$myReaction->type] ?? 'Me gusta') : 'Me gusta';
    @endphp

    <div class="flex text-[#606770] font-bold text-[13px] py-1 border-t border-[#e9eaed] mx-3 overflow-visible relative">
        
        <div class="flex-1 group relative">
            <div class="absolute bottom-8 left-0 bg-white rounded-full shadow-lg border border-gray-200 px-2 py-1 flex gap-2 items-center opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                @foreach(['like'=>'👍','love'=>'❤️','haha'=>'😆','sad'=>'😢','angry'=>'😡'] as $type=>$emoji)
                    <form action="{{ route('reaction.toggle') }}" method="POST" class="inline">
                        @csrf 
                        <input type="hidden" name="reactable_id" value="{{ $post->id }}"> 
                        <input type="hidden" name="reactable_type" value="App\Models\Post"> 
                        <input type="hidden" name="type" value="{{ $type }}">
                        <button class="text-2xl hover:scale-125 transition-transform">{{ $emoji }}</button>
                    </form>
                @endforeach
            </div>
            
            <form action="{{ route('reaction.toggle') }}" method="POST" class="w-full h-full">
                @csrf 
                <input type="hidden" name="reactable_id" value="{{ $post->id }}"> 
                <input type="hidden" name="reactable_type" value="App\Models\Post"> 
                <input type="hidden" name="type" value="like">
                <button class="w-full h-full flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] rounded {{ $currColor }}">
                    @if($myReaction) 
                        <span>{{ $myReaction->type == 'like' ? '👍' : ($myReaction->type == 'love' ? '❤️' : '😮') }}</span> 
                    @else 
                        <svg class="w-5 h-5 fill-gray-500" viewBox="0 0 24 24"><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z"/></svg>
                    @endif
                    <span>{{ $currText }}</span>
                </button>
            </form>
        </div>
        
        <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded" 
             @click="showComments = true; $nextTick(() => $refs.commentInput.focus())">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#606770" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            Comentar
        </div>

        <div class="flex-1 flex items-center justify-center gap-1 py-1 hover:bg-[#f2f3f5] cursor-pointer rounded"
             @click="showShareModal = true">
             <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#606770" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>
            Compartir
        </div>
    </div>

    {{-- ================= SECCIÓN DE COMENTARIOS ================= --}}
    <div x-show="showComments" class="bg-[#f5f6f7] p-3 border-t border-[#e9eaed]">
        
        @if($post->comments->count() > 0)
            <div class="space-y-2 mb-3">
                @foreach($post->comments as $comment)
                <div class="flex gap-2 group">
                    <img src="{{ $comment->author->avatar ?? 'https://ui-avatars.com/api/?name=U' }}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                    <div>
                        <div class="bg-white border border-[#e9eaed] rounded-2xl px-3 py-2 inline-block">
                            <a href="{{ route('profile.show', $comment->author->username ?? '#') }}" class="font-bold text-[#365899] text-[13px] hover:underline">
                                {{ $comment->author->name ?? 'Usuario' }}
                            </a>
                            <span class="text-[13px] text-[#1d2129] ml-1">{{ $comment->content }}</span>
                        </div>
                        <div class="text-[12px] text-[#65676b] ml-3 mt-0.5 flex gap-2">
                            <span class="hover:underline cursor-pointer font-bold text-[#65676b]">Me gusta</span>
                            <span class="text-xs">{{ $comment->created_at->diffForHumans(null, true, true) }}</span>
                            
                            @if(Auth::id() === $comment->user_id || Auth::id() === $post->user_id)
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-600 ml-2 font-bold" title="Eliminar">x</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
        
        <div class="flex gap-2">
            <img src="{{ Auth::user()->avatar }}" class="w-8 h-8 rounded-full border border-gray-200 object-cover">
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex-grow relative">
                @csrf
                <input x-ref="commentInput"
                       type="text" 
                       name="content" 
                       class="w-full rounded-[18px] border border-[#dddfe2] py-2 pl-3 pr-8 text-[13px] focus:ring-0 placeholder-gray-500" 
                       placeholder="Escribe un comentario..." 
                       required 
                       autocomplete="off">
                <button type="submit" class="hidden"></button>
            </form>
        </div>
    </div>

    {{-- ================= MODAL DE COMPARTIR ================= --}}
    <div x-show="showShareModal" 
         class="fixed inset-0 z-[999] flex items-center justify-center bg-black/60 backdrop-blur-sm"
         style="display: none;"
         x-transition.opacity>
        
        <div class="bg-white w-full max-w-lg rounded-lg shadow-2xl overflow-hidden" @click.outside="showShareModal = false">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-bold text-gray-800">Compartir publicación</h3>
                <button @click="showShareModal = false" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold">✕</button>
            </div>

            <form action="{{ route('post.share', $post->id) }}" method="POST">
                @csrf
                <div class="p-4">
                    <div class="mb-4">
                        <label class="text-xs font-bold text-gray-500 uppercase">¿Dónde quieres compartirlo?</label>
                        <select x-model="shareType" name="destination" class="w-full mt-1 border-gray-300 rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="profile">📰 En mi Muro</option>
                            <option value="group">👥 En un Grupo</option>
                            <option value="page">🚩 En una Página</option>
                        </select>
                    </div>

                    <div x-show="shareType === 'group'" class="mb-4">
                        <label class="text-xs font-bold text-gray-500">Elige el grupo:</label>
                        <select name="destination_id" class="w-full mt-1 border-gray-300 rounded-md text-sm">
                            @foreach(Auth::user()->groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="shareType === 'page'" class="mb-4">
                        <label class="text-xs font-bold text-gray-500">Elige la página:</label>
                        <select name="destination_id" class="w-full mt-1 border-gray-300 rounded-md text-sm">
                            @foreach(\App\Models\Page::where('user_id', Auth::id())->get() as $page)
                                <option value="{{ $page->id }}">{{ $page->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3 mb-2">
                        <img src="{{ Auth::user()->avatar }}" class="w-10 h-10 rounded-full border border-gray-200">
                        <div class="flex-grow">
                            <div class="font-bold text-sm text-gray-800 mb-1">{{ Auth::user()->name }}</div>
                            <textarea name="content" rows="2" class="w-full border-none p-0 text-sm focus:ring-0 placeholder-gray-500" placeholder="Haz un comentario..."></textarea>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-3 bg-gray-50 text-sm text-gray-500">
                        <div class="font-bold mb-1">{{ $post->author->name }}</div>
                        <div class="line-clamp-2 italic">"{{ Str::limit($post->content, 80) }}"</div>
                    </div>
                </div>

                <div class="p-3 border-t bg-gray-50 flex justify-end gap-2">
                    <button type="button" @click="showShareModal = false" class="px-4 py-2 text-sm font-bold text-gray-600 hover:bg-gray-200 rounded-md">Cancelar</button>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-[#1877f2] hover:bg-[#166fe5] rounded-md">Compartir</button>
                </div>
            </form>
        </div>
    </div>
</div>