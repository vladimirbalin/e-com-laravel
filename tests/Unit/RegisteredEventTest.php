<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Notifications\WelcomeUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Src\Domain\Auth\Models\User;
use Tests\TestCase;

class RegisteredEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_welcome_notification()
    {
        $payload = [
            'name' => 'Test',
            'email' => 'testing@stepsel.ru',
            'password' => bcrypt('12345678'),
        ];

        $user = User::create($payload);

        $event = new Registered($user);
        event($event);

        Notification::assertSentTo($user, WelcomeUserNotification::class);
    }
}
