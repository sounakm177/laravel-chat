<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Repositories\Interfaces\ChatRepositoryInterface;

class ChatRepository implements ChatRepositoryInterface
{
    public function create(array $data): Chat
    {
        return Chat::create($data);
    }

    public function findById(int $id): ?Chat
    {
        return Chat::find($id);
    }

    public function getAllChatsForUser(int $userId)
    {
        return Chat::where('user_id', $userId)->get();
    }

    public function delete(int $id): bool
    {
        $chat = $this->findById($id);

        return $chat ? $chat->delete() : false;
    }
}
