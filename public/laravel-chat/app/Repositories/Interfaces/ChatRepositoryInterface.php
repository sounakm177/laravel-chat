<?php

namespace App\Repositories\Interfaces;

interface ChatRepositoryInterface
{
    public function createChat(array $data);
    
    public function getChatById(int $id);
    
    public function getUserChats(int $userId);
    
    public function deleteChat(int $id);
}