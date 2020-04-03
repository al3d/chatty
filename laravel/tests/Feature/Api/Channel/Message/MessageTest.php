<?php

namespace Tests\Feature\Api\Channel\Message;

use App\Events\Message\Created;
use App\Events\Message\Deleted;
use App\Events\Message\Updated;
use App\Models\Channel;
use App\Models\Message;
use App\Models\User;
use DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MessageTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function testCreateMessage()
    {
        Event::fake([
            Created::class,
        ]);

        $user = User::first();
        $channel = Channel::first();

        $response = $this
            ->actingAs($user)
            ->postJson(sprintf('/api/channels/%s/messages', $channel->name), [
                'message' => 'This is a message',
            ])
        ;

        Event::assertDispatched(Created::class, function ($event) use ($user, $channel) {
            $message = $event->message;
            return $message->channel->id === $channel->id && $message->user->id === $user->id;
        });

        $response->assertStatus(201);
    }

    public function testDeleteMessage()
    {
        Event::fake([
            Deleted::class,
        ]);

        $message = Message::all()->random();

        $response = $this
            ->actingAs($message->user)
            ->deleteJson(sprintf('/api/channels/%s/messages/%s', Channel::first()->name, $message->uuid))
        ;

        Event::assertDispatched(Deleted::class, function ($event) use ($message) {
            return $event->uuid === $message->uuid;
        });

        $response->assertStatus(204);
    }

    public function testListMessages()
    {
        $response = $this
            ->actingAs(User::first())
            ->getJson(sprintf('/api/channels/%s/messages', Channel::first()->name))
        ;

        $response->assertStatus(200);
    }

    public function testShowMessage()
    {
        $response = $this
            ->actingAs(User::first())
            ->getJson(sprintf('/api/channels/%s/messages/%s', Channel::first()->name, Message::all()->random()->uuid))
        ;

        $response->assertStatus(200);
    }

    public function testUpdateMessage()
    {
        Event::fake([
            Updated::class,
        ]);

        $message = Message::all()->random();

        $response = $this
            ->actingAs($message->user)
            ->patchJson(sprintf('/api/channels/%s/messages/%s', $message->channel->name, $message->uuid), [
                'message' => 'New message',
            ])
        ;

        Event::assertDispatched(Updated::class, function ($event) use ($message) {
            return $event->message->uuid === $message->uuid;
        });

        $response->assertStatus(200);
    }
}
