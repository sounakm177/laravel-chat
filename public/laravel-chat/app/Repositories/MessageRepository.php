Sure, here's the contents for the file /laravel-chat/laravel-chat/app/Repositories/MessageRepository.php:

<?php

namespace App\Repositories;

use App\Models\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    public function create(array $data): Message
    {
        return Message::create($data);
    }

    public function findById(int $id): ?Message
    {
        return Message::find($id);
    }

    public function getMessagesByChatId(int $chatId)
    {
        return Message::where('chat_id', $chatId)->get();
    }

    public function update(int $id, array $data): bool
    {
        $message = $this->findById($id);
        if ($message) {
            return $message->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $message = $this->findById($id);
        if ($message) {
            return $message->delete();
        }
        return false;
    }
}