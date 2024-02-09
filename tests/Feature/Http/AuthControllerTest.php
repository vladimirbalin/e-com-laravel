<?php

namespace Http;

use App\Listeners\SendWelcomeUserNotification;
use App\Models\User;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_login_post_success(): void
    {
        Event::fake();
        Notification::fake();

        $payload = [
            'name' => 'Test',
            'email' => 'testing@cutcode.ru',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $response = $this->post(route('register-post'), $payload);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', ['email' => $payload['email']]);
        $user = User::query()->where(['email' => $payload['email']])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendWelcomeUserNotification::class);

        $event = new Registered($user);
        $listener = new SendWelcomeUserNotification();

        $listener->handle($event);

        Notification::assertSentTo($user, WelcomeUserNotification::class);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

}
