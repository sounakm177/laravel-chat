<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatRequest;
use App\Http\Resources\ChatResource;
use App\Repositories\ChatRepository;

class ChatController extends Controller
{
    protected $chatRepository;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function index()
    {
        $chats = $this->chatRepository->getAllChats();

        return ChatResource::collection($chats);
    }

    public function show($id)
    {
        $chat = $this->chatRepository->findChatById($id);

        return new ChatResource($chat);
    }

    public function store(StoreChatRequest $request)
    {
        $chat = $this->chatRepository->createChat($request->validated());

        return new ChatResource($chat);
    }
}
