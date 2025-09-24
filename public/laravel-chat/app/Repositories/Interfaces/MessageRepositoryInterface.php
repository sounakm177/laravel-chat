<?php

namespace App\Repositories\Interfaces;

interface MessageRepositoryInterface
{
    public function create(array $data);
    public function findById($id);
    public function getChatMessages($chatId);
    public function markAsRead($messageId);
}