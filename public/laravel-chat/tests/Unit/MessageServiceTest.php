<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MessageService;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $messageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageService = new MessageService();
    }

    public function test_can_send_message()
    {
        $messageData = [
            'chat_id' => 1,
            'user_id' => 1,
            'body' => 'Hello, World!',
        ];

        $message = $this->messageService->sendMessage($messageData);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals('Hello, World!', $message->body);
    }

    public function test_can_retrieve_message_history()
    {
        $chatId = 1;
        $messages = $this->messageService->getMessageHistory($chatId);

        $this->assertIsArray($messages);
    }

    public function test_message_delivery_failure()
    {
        $this->expectException(\App\Exceptions\MessageDeliveryException::class);

        $messageData = [
            'chat_id' => null, // Invalid chat_id
            'user_id' => 1,
            'body' => 'This will fail',
        ];

        $this->messageService->sendMessage($messageData);
    }
}