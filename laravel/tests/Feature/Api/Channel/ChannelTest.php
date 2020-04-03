<?php

namespace Tests\Feature\Api\Channel;

use App\Models\Channel;
use App\Models\User;
use DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function testCreateChannel()
    {
        $response = $this
            ->actingAs(User::first())
            ->postJson('/api/channels', [
                'name' => 'new-channel',
                'description' => 'This is a description',
            ])
        ;

        $response->assertStatus(201);
    }

    public function testDeleteChannel()
    {
        $channel = factory(Channel::class)->create();
        $channel
            ->creator()
            ->associate(User::first())
            ->save()
        ;

        $response = $this
            ->actingAs($channel->creator)
            ->deleteJson(sprintf('/api/channels/%s', $channel->name))
        ;

        $response->assertStatus(204);
    }

    public function testLeaveChannel()
    {
        $user = User::first();
        $channel = factory(Channel::class)->create();
        $channel
            ->members()
            ->attach($user)
        ;

        $response = $this
            ->actingAs($user)
            ->patchJson(sprintf('/api/channels/%s/leave', $channel->name))
        ;

        $response->assertStatus(204);
    }

    public function testListChannels()
    {
        $response = $this
            ->actingAs(User::first())
            ->getJson('/api/channels')
        ;

        $response->assertStatus(200);
    }

    public function testShowChannel()
    {
        $channel = factory(Channel::class)->create();

        $response = $this
            ->actingAs(User::first())
            ->getJson(sprintf('/api/channels/%s', $channel->name))
        ;

        $response->assertStatus(200);
    }

    public function testUpdateChannel()
    {
        $channel = factory(Channel::class)->create();
        $channel
            ->creator()
            ->associate(User::first())
            ->save()
        ;

        $response = $this
            ->actingAs(User::first())
            ->patchJson(sprintf('/api/channels/%s', $channel->name), [
                'description' => 'New description',
            ])
        ;

        $response->assertStatus(200);
    }
}
