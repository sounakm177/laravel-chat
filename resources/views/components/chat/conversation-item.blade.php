@props(['chat', 'active' => false])

<a href="{{ route('chat.show', $chat) }}" 
   class="block p-4 hover:bg-gray-50 {{ $active ? 'bg-gray-50' : '' }}">
    <div class="flex justify-between">
        <div class="flex space-x-3">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                    {{ substr($chat->is_group ? $chat->name : $chat->users->where('id', '!=', auth()->id())->first()->name, 0, 1) }}
                </div>
                <x-chat.online-status :user="$chat->users->where('id', '!=', auth()->id())->first()" />
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">
                    {{ $chat->is_group ? $chat->name : $chat->users->where('id', '!=', auth()->id())->first()->name }}
                </p>
                @if($chat->lastMessage)
                    <p class="text-sm text-gray-500 truncate">
                        {{ $chat->lastMessage->content }}
                    </p>
                @endif
            </div>
        </div>
        <div class="flex flex-col items-end">
            @if($chat->lastMessage)
                <span class="text-xs text-gray-500">
                    {{ $chat->lastMessage->created_at->diffForHumans() }}
                </span>
            @endif
            @php
                $unreadCount = $chat->messages()
                    ->where('user_id', '!=', auth()->id())
                    ->where('is_read', false)
                    ->count();
            @endphp
            @if($unreadCount > 0)
                <span class="px-2 py-1 text-xs bg-blue-500 text-white rounded-full">
                    {{ $unreadCount }}
                </span>
            @endif
        </div>
    </div>
</a>