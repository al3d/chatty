<?php

namespace Tests\Feature\Auth;

use App\Notifications\MagicLinkNotification;
use App\Models\User;
use App\Notifications\RegisteredNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    public function testStartDoesntExist()
    {
        $response = $this->postJson('/auth/start', [
            'email' => 'unknown@example.com',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['exists' => false])
        ;
    }

    public function testStartUserExists()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/auth/start', [
            'email' => $user->email,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['exists' => true])
        ;
    }

    public function testRegister()
    {
        Notification::fake();

        $email = 'newuser@example.com';

        $response = $this->postJson('/auth/register', [
            'name' => 'New User',
            'email' => $email,
        ]);

        $user = User::whereEmail($email)->first();

        Notification::assertSentTo($user, RegisteredNotification::class);

        $response->assertStatus(201);
    }

    public function testRegisterFails()
    {
        $response = $this->postJson('/auth/register', [
            'name' => 'New User',
        ]);

        $response->assertStatus(422);
    }

    public function testNormalLogin()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/auth/login', [
            'email' => $user->email,
            'password' => 'password', // factory passwords are always 'password'
        ]);

        $response->assertStatus(204);
    }

    public function testNormalLoginFails()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/auth/login', [
            'email' => $user->email,
            'password' => 'unknown',
        ]);

        $response->assertStatus(422);
    }

    public function testMagicLinkRequest()
    {
        $user = factory(User::class)->create();

        Notification::fake();

        $response = $this->postJson('/auth/login', [
            'email' => $user->email,
            'magic_link' => true,
        ]);

        Notification::assertSentTo($user, MagicLinkNotification::class);

        $response->assertStatus(204);
    }

    public function testMagicLinkRequestFails()
    {
        $response = $this->postJson('/auth/login', [
            'email' => 'unknown@example.com',
            'magic_link' => true,
        ]);

        $response->assertStatus(422);
    }

    public function testLoginViaMagicLink()
    {
        $user = factory(User::class)->create();
        $url = $user->generateLoginMagicLink(false, 24, false);

        $response = $this->getJson($url);

        $response->assertStatus(204);
    }

    public function testLogout()
    {
        $user = factory(User::class)->create();

        Auth::login($user);

        $response = $this->postJson('/auth/logout');

        $response->assertStatus(204);
    }
}
