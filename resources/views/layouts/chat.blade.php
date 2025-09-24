<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Left Sidebar - Chat List -->
        <div class="w-1/4 bg-white border-r overflow-y-auto">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold">Messages</h2>
            </div>
            <!-- Chat List -->
            <div class="space-y-2">
                @foreach($chats as $chat)
                    <a href="{{ route('chat.show', $chat->id) }}" 
                       class="block p-4 hover:bg-gray-50 {{ request()->route('chat') && request()->route('chat')->id == $chat->id ? 'bg-gray-50' : '' }}">
                        <div class="flex justify-between">
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <!-- User Avatar -->
                                    <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                        {{ substr($chat->is_group ? $chat->name : $chat->users->where('id', '!=', auth()->id())->first()->name, 0, 1) }}
                                    </div>
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
                @endforeach
            </div>
        </div>

        <!-- Right Content - Welcome Screen -->
        <div class="flex-1 flex items-center justify-center bg-gray-50">
            <div class="text-center">
                <h3 class="text-xl font-medium text-gray-900">Welcome to Laravel Chat</h3>
                <p class="mt-1 text-sm text-gray-500">Select a conversation to start chatting</p>
            </div>
        </div>
    </div>
</x-app-layout>