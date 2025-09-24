<?php
namespace App\Services;

use App\Models\User;
use App\Models\Chat;
use App\Repositories\ChatRepository;
use App\Events\MessageSent;
use App\Events\UserTyping;

class ChatService
{
    protected $chatRepository;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function getUserChats(User $user)
    {
        return $this->chatRepository->getAllForUser($user);
    }

    public function startChat(User $user1, User $user2): Chat
    {
        return $this->chatRepository->createPrivateChat($user1, $user2);
    }

    public function sendMessage(Chat $chat, User $user, string $content, string $type = 'text')
    {
        $message = $chat->messages()->create([
            'user_id' => $user->id,
            'content' => $content,
            'type' => $type
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }

    public function markAsRead(Chat $chat, User $user)
    {
        $chat->messages()
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $chat->users()->updateExistingPivot($user->id, [
            'last_read_at' => now()
        ]);
    }

    public function userIsTyping(Chat $chat, User $user)
    {
        broadcast(new UserTyping($chat, $user))->toOthers();
    }
}