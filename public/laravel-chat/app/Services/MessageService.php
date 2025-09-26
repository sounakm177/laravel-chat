<?php

namespace App\Services;

use App\Exceptions\MessageDeliveryException;
use App\Models\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageService
{
    protected $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function sendMessage(array $data): Message
    {
        try {
            return $this->messageRepository->create($data);
        } catch (\Exception $e) {
            throw new MessageDeliveryException('Failed to deliver message: '.$e->getMessage());
        }
    }

    public function getMessagesForChat($chatId)
    {
        return $this->messageRepository->getMessagesByChatId($chatId);
    }
}
