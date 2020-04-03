<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{

    use RefreshDatabase;

    public function testMeEndpoint()
    {
        $user = factory(User::class)->make();

        $response = $this
            ->actingAs($user)
            ->getJson('/api/me')
        ;

        $response
            ->assertStatus(200)
            ->assertJson(['data' => true])
        ;
    }
}
