<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_chat()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/chats', [
            'name' => 'New Chat',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('chats', ['name' => 'New Chat']);
    }

    public function test_user_can_send_message()
    {
        $user = User::factory()->create();
        $chat = Chat::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/chats/' . $chat->id . '/messages', [
            'body' => 'Hello, World!',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('messages', ['body' => 'Hello, World!']);
    }

    public function test_user_can_retrieve_chat_history()
    {
        $user = User::factory()->create();
        $chat = Chat::factory()->create();
        $message = Message::factory()->create(['chat_id' => $chat->id]);

        $this->actingAs($user);

        $response = $this->getJson('/api/chats/' . $chat->id . '/messages');

        $response->assertStatus(200);
        $response->assertJsonFragment(['body' => $message->body]);
    }

    public function test_user_typing_event_is_broadcasted()
    {
        Broadcast::shouldReceive('event')->once();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/chats/1/typing');

        $response->assertStatus(200);
    }
}