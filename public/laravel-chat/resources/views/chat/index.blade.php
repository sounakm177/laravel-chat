Sure, here's the contents for the file /laravel-chat/laravel-chat/resources/views/chat/index.blade.php:

@extends('layouts.app')

@section('content')
<div class="flex">
    <div class="w-1/4 bg-gray-100 p-4">
        <h2 class="text-lg font-semibold">Conversations</h2>
        <ul id="chat-list">
            @foreach($chats as $chat)
                <li class="flex justify-between items-center p-2 border-b">
                    <a href="{{ route('chat.show', $chat->id) }}" class="flex-1">
                        <span class="font-bold">{{ $chat->user->name }}</span>
                        <span class="text-gray-600">{{ $chat->latestMessage->content ?? 'No messages yet' }}</span>
                    </a>
                    <span class="text-xs text-gray-500">{{ $chat->latestMessage->created_at->diffForHumans() }}</span>
                    @if($chat->unread_count > 0)
                        <span class="bg-red-500 text-white rounded-full px-2">{{ $chat->unread_count }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
    <div class="w-3/4 p-4">
        <h2 class="text-lg font-semibold">Select a conversation</h2>
        <div id="active-chat">
            <p class="text-gray-500">Please select a conversation to start chatting.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add your JavaScript for real-time updates and typing indicators here
</script>
@endsection