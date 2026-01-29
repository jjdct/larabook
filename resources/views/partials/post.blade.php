<div class="bg-white fb-border rounded-[2px] mb-3">
    <div class="p-3 pb-0">
        <div class="flex gap-2 mb-2">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" class="w-10 h-10 rounded-[2px] border border-gray-200">
            <div>
                <a href="{{ route('users.show', $post->user) }}" class="fb-link text-[13px] block leading-tight">
                    {{ $post->user->name }}
                </a>
                
                <a href="{{ route('posts.show', $post) }}" class="text-[11px] text-[#9197a3] hover:underline cursor-pointer">
                    {{ $post->created_at->diffForHumans() }}
                </a>
            </div>
        </div>
        
        @if($post->content)
            <p class="text-[13px] text-[#141823] mb-2 leading-snug">
                {{ $post->content }}
            </p>
        @endif
    </div>

    @if($post->image_path)
    <div class="mt-2 border-t border-b border-[#e9eaed] bg-black bg-opacity-5 cursor-pointer">
        <a href="{{ route('posts.show', $post) }}">
            <img src="{{ asset('storage/' . $post->image_path) }}" class="w-full h-auto max-h-[500px] object-contain mx-auto">
        </a>
    </div>
    @endif

    <div class="px-3 pb-1 pt-1">
        <div class="text-[11px] flex gap-4 mt-1 mb-1 items-center">
            
            <form action="{{ route('posts.like', $post) }}" method="POST" class="m-0">
                @csrf
                @if($post->isLikedBy(auth()->user()))
                    <button type="submit" class="text-[#3b5998] font-bold cursor-pointer hover:underline bg-transparent border-none p-0">
                        Ya no me gusta
                    </button>
                @else
                    <button type="submit" class="text-[#3b5998] font-bold cursor-pointer hover:underline bg-transparent border-none p-0">
                        Me gusta
                    </button>
                @endif
            </form>

            <span class="text-[#3b5998] font-bold cursor-pointer hover:underline" onclick="document.getElementById('comment-box-{{ $post->id }}').focus()">
                Comentar
            </span>
        </div>
    </div>
    
    <div class="bg-[#f6f7f9] border-t border-[#e9eaed] px-3 py-2">
        
        @if($post->likes->count() > 0)
        <div class="flex items-center gap-1 text-[11px] text-[#4b4f56] mb-2 border-b border-[#e9eaed] pb-1">
            <span class="text-lg leading-none">👍</span> 
            <span class="hover:underline cursor-pointer">
                @if($post->isLikedBy(auth()->user()))
                    @if($post->likes->count() == 1)
                        A ti te gusta esto.
                    @else
                        A ti y a {{ $post->likes->count() - 1 }} personas más les gusta esto.
                    @endif
                @else
                    A {{ $post->likes->count() }} personas les gusta esto.
                @endif
            </span>
        </div>
        @endif

        @foreach($post->comments as $comment)
        <div class="flex gap-1.5 mb-1.5 text-[11px]">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random" class="w-6 h-6 border border-gray-200 shrink-0">
            <div>
                <a href="{{ route('users.show', $comment->user) }}" class="fb-link">{{ $comment->user->name }}</a>
                <span class="text-[#141823]">{{ $comment->body }}</span>
                <div class="text-gray-400 text-[10px] mt-0.5">
                    {{ $comment->created_at->diffForHumans() }} 
                </div>
            </div>
        </div>
        @endforeach

        <div class="flex gap-1.5 mt-2">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" class="w-6 h-6 square shrink-0">
            <form action="{{ route('posts.comment', $post) }}" method="POST" class="w-full">
                @csrf
                <input id="comment-box-{{ $post->id }}" type="text" name="body" placeholder="Escribe un comentario..." 
                       class="w-full border border-[#bdc7d8] p-1 text-[11px] focus:outline-none focus:border-[#3b5998]" autocomplete="off">
            </form>
        </div>

    </div>
</div>