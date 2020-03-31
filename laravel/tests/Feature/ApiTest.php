<?php

namespace Tests\Feature;

use App\Notifications\MagicLinkNotification;
use App\Models\User;
use App\Notifications\RegisteredNotification;
use UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ApiTest extends TestCase
{

    use RefreshDatabase;

    public function testMeEndpoint()
    {
        $this->seed(UserSeeder::class);

        $user = User::whereEmail('admin@example.com')->first();

        $response = $this
            ->actingAs($user)
            ->getJson('/api/me');

        $response->assertStatus(200);
        $response->assertJson(['data' => true]);
    }
}
