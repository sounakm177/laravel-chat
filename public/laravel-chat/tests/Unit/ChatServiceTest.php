Sure, here's the contents for the file /laravel-chat/laravel-chat/tests/Unit/ChatServiceTest.php:

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ChatService;
use App\Models\User;
use App\Models\Chat;

class ChatServiceTest extends TestCase
{
    protected $chatService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->chatService = new ChatService();
    }

    public function testCreateChat()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $chat = $this->chatService->createChat($user1->id, $user2->id);

        $this->assertInstanceOf(Chat::class, $chat);
        $this->assertEquals($user1->id, $chat->user1_id);
        $this->assertEquals($user2->id, $chat->user2_id);
    }

    public function testGetChat()
    {
        $chat = Chat::factory()->create();

        $fetchedChat = $this->chatService->getChat($chat->id);

        $this->assertEquals($chat->id, $fetchedChat->id);
    }

    public function testChatNotFound()
    {
        $this->expectException(\App\Exceptions\ChatNotFoundException::class);

        $this->chatService->getChat(999); // Assuming 999 does not exist
    }
}