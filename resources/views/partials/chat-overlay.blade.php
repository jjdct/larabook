@unless(request()->routeIs('messages.*'))

    <div class="fixed right-0 bottom-0 w-[205px] bg-[#e9eaed] border-l border-t border-[#bdc7d8] hidden xl:flex flex-col z-40 h-[calc(100vh-42px)]">
        <div class="p-2 font-bold text-[#333] text-[11px] border-b border-[#d8dfea] flex justify-between items-center cursor-pointer hover:bg-[#eff1f3]">
            <span>Chat ({{ $globalFriends->count() }})</span>
            <span class="text-gray-500">⚙️</span>
        </div>
        <div class="overflow-y-auto flex-1 p-1 space-y-1 no-scrollbar bg-[#e9eaed]">
            @foreach($globalFriends as $friend)
            <a href="{{ route('messages.show', $friend) }}" class="flex items-center gap-2 p-1.5 hover:bg-[#d8dfea] cursor-pointer rounded-[2px] group text-decoration-none block">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($friend->name) }}&background=random" class="w-6 h-6 border border-gray-300">
                <div class="flex-1 flex justify-between items-center">
                    <span class="text-[11px] text-[#141823] group-hover:underline truncate w-[100px]">{{ $friend->name }}</span>
                    <div class="w-1.5 h-1.5 bg-[#62c462] rounded-full border border-[#489a48]"></div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="p-1 border-t border-[#bdc7d8] bg-[#f6f7f9]">
            <input type="text" placeholder="Buscar" class="w-full border border-[#bdc7d8] text-[11px] px-1 py-0.5 focus:outline-none">
        </div>
    </div>

    @if(isset($globalActiveChatUser))
    <div id="mini-chat-window" class="fixed bottom-0 right-[215px] w-[260px] bg-white border border-[#bdc7d8] border-b-0 rounded-t-[3px] shadow-sm z-50 hidden md:flex flex-col">
        
        <div class="bg-[#3b5998] border-b border-[#2d4373] p-1.5 flex justify-between items-center cursor-pointer rounded-t-[3px] text-white">
            <a href="{{ route('messages.show', $globalActiveChatUser) }}" class="flex items-center gap-1.5 text-white hover:no-underline">
                <div class="w-1.5 h-1.5 bg-[#62c462] rounded-full ring-1 ring-white"></div>
                <span class="font-bold text-[11px] hover:underline">{{ $globalActiveChatUser->name }}</span>
            </a>
            <div class="flex gap-2 font-bold text-[12px] opacity-80">
                <span class="hover:opacity-100">⚙️</span>
                <span class="hover:opacity-100 cursor-pointer" onclick="document.getElementById('mini-chat-window').style.display='none'">✖</span>
            </div>
        </div>

        <div class="h-[240px] overflow-y-auto p-2 bg-white border-b border-[#bdc7d8] space-y-2 flex flex-col justify-end">
            @foreach($globalActiveChatMessages as $msg)
            <div class="flex gap-1.5">
                @if($msg->sender_id !== auth()->id())
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($globalActiveChatUser->name) }}&background=random" class="w-6 h-6 border border-gray-300 self-start">
                @endif
                <div class="text-[11px] text-[#141823] {{ $msg->sender_id === auth()->id() ? 'ml-auto text-right bg-[#f6f7f9] p-1 rounded border border-[#e9eaed]' : '' }} max-w-[85%]">
                    <span>{{ $msg->body }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="p-1.5">
            <form action="{{ route('messages.store', $globalActiveChatUser) }}" method="POST">
                @csrf
                <input type="text" name="body" class="w-full border border-[#bdc7d8] p-1 text-[11px] focus:outline-none focus:border-[#3b5998]" placeholder="Escribe un mensaje..." autocomplete="off">
            </form>
        </div>
    </div>
    @endif

@endunless