<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function send(StoreMessageRequest $request)
    {
        $message = $this->messageService->sendMessage($request->validated());

        return new MessageResource($message);
    }

    public function index(Request $request, $chatId)
    {
        $messages = $this->messageService->getMessagesForChat($chatId);

        return MessageResource::collection($messages);
    }
}
