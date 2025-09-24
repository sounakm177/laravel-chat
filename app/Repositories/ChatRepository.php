<?php
namespace App\Repositories;

use App\Models\Chat;
use App\Models\User;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use App\Exceptions\Chat\ChatNotFoundException;

class ChatRepository implements ChatRepositoryInterface
{
    public function getAllForUser(User $user)
    {
        return $user->chats()
            ->with(['users', 'lastMessage'])
            ->latest('updated_at')
            ->get();
    }

    public function findById(int $id)
    {
        $chat = Chat::find($id);
        
        if (!$chat) {
            throw new ChatNotFoundException("Chat not found");
        }

        return $chat;
    }

    public function createPrivateChat(User $user1, User $user2): Chat
    {
        $chat = Chat::create(['is_group' => false]);
        $chat->users()->attach([$user1->id, $user2->id]);
        return $chat;
    }

    public function createGroupChat(string $name, User $creator, array $userIds): Chat
    {
        $chat = Chat::create([
            'name' => $name,
            'is_group' => true
        ]);
        
        $userIds[] = $creator->id;
        $chat->users()->attach($userIds);
        
        return $chat;
    }

    public function getUnreadCount(Chat $chat, User $user): int
    {
        return $chat->messages()
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->count();
    }
}