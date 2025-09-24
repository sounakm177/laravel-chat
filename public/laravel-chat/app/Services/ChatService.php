Sure, here's the contents for the file /laravel-chat/laravel-chat/app/Services/ChatService.php:

<?php

namespace App\Services;

use App\Repositories\ChatRepositoryInterface;
use App\Exceptions\ChatNotFoundException;

class ChatService
{
    protected $chatRepository;

    public function __construct(ChatRepositoryInterface $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function createChat($data)
    {
        return $this->chatRepository->create($data);
    }

    public function getChatById($id)
    {
        $chat = $this->chatRepository->find($id);

        if (!$chat) {
            throw new ChatNotFoundException("Chat not found.");
        }

        return $chat;
    }

    public function getUserChats($userId)
    {
        return $this->chatRepository->getUserChats($userId);
    }
}