<div class="w-1/4 bg-white border-r overflow-y-auto">
    <div class="p-4 border-b">
        <h2 class="text-xl font-semibold">Messages</h2>
    </div>
    <div class="space-y-2">
        @foreach($chats as $chatItem)
            <a href="{{ route('chat.show', $chatItem->id) }}" 
               class="block p-4 hover:bg-gray-50 {{ $chat->id == $chatItem->id ? 'bg-gray-50' : '' }}">
                <div class="flex justify-between">
                    <div class="flex space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                {{ substr($chatItem->is_group ? $chatItem->name : $chatItem->users->where('id', '!=', auth()->id())->first()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $chatItem->is_group ? $chatItem->name : $chatItem->users->where('id', '!=', auth()->id())->first()->name }}
                            </p>
                            @if($chatItem->lastMessage)
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $chatItem->lastMessage->content }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>