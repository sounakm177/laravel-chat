<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatService;
use App\Http\Requests\StoreChatRequest;
use App\Models\User;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        $chats = $this->chatService->getUserChats(auth()->user());
        return view('chat.index', compact('chats'));
    }

    public function show(int $id)
    {
        $chat = Chat::with(['messages.user', 'users'])->findOrFail($id);
        $this->chatService->markAsRead($chat, auth()->user());
        
        return view('chat.show', compact('chat'));
    }

    public function store(StoreChatRequest $request)
    {
        $recipient = User::findOrFail($request->recipient_id);
        $chat = $this->chatService->startChat(auth()->user(), $recipient);
        
        return redirect()->route('chat.show', $chat);
    }

    public function typing(Request $request, $chatId)
    {
        $chat = Chat::findOrFail($chatId);
        $this->chatService->userIsTyping($chat, auth()->user());
        
        return response()->json(['status' => 'ok']);
    }
}
