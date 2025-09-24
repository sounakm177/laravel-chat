<?php
namespace App\Repositories\Interfaces;

use App\Models\Chat;
use App\Models\User;

interface ChatRepositoryInterface
{
    public function getAllForUser(User $user);
    public function findById(int $id);
    public function createPrivateChat(User $user1, User $user2): Chat;
    public function createGroupChat(string $name, User $creator, array $userIds): Chat;
    public function getUnreadCount(Chat $chat, User $user): int;
}