<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_message()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $this->actingAs($sender)
            ->post('/api/messages', [
                'receiver_id' => $receiver->id,
                'content' => 'Hello!',
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'content' => 'Hello!',
        ]);
    }

    public function test_user_can_retrieve_messages()
    {
        $user = User::factory()->create();
        $receiver = User::factory()->create();

        Message::factory()->create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'content' => 'Hello!',
        ]);

        $this->actingAs($user)
            ->get('/api/messages?receiver_id=' . $receiver->id)
            ->assertStatus(200)
            ->assertJsonFragment(['content' => 'Hello!']);
    }

    public function test_typing_indicator_is_broadcasted()
    {
        Broadcast::fake();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/api/typing', [
                'receiver_id' => 1,
            ]);

        Broadcast::assertSent(UserTyping::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }
}