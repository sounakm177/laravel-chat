<?php

namespace App\Services;

use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Models\Message;
use App\Exceptions\MessageDeliveryException;

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
            throw new MessageDeliveryException('Failed to deliver message: ' . $e->getMessage());
        }
    }

    public function getMessagesForChat($chatId)
    {
        return $this->messageRepository->getMessagesByChatId($chatId);
    }
}