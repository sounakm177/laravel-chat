<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $chatId;

    public function __construct($userId, $chatId)
    {
        $this->userId = $userId;
        $this->chatId = $chatId;
    }
}