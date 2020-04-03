<?php

namespace Tests\Feature\Api\Channel\Member;

use App\Models\Channel;
use App\Models\User;
use DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function testListMembers()
    {
        $channel = Channel::first();

        $response = $this
            ->actingAs(User::first())
            ->getJson(sprintf('/api/channels/%s', $channel->name))
        ;

        $response->assertStatus(200);
    }
}
