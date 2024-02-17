<?php
declare(strict_types=1);

namespace Tests\Feature\Http;

use Database\Factories\UserFactory;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Src\Domain\Auth\Models\User;
use Src\Support\Flash\Flash;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;
    protected array $payload;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->userFactory()->create();
        $this->token = Password::createToken($this->user);

        $this->payload = [
            'email' => $this->user->email,
            'password' => $newPassword = Str::random(8),
            'password_confirmation' => $newPassword,
            'token' => $this->token,
        ];
    }

    private function userFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function request(): \Illuminate\Testing\TestResponse
    {
        return $this->post(route('password.update'), $this->payload);
    }

    public function test_reset_password(): void
    {
        $this->get(route('password.reset', ['token' => $this->token]))
            ->assertOk()
            ->assertViewIs('auth.reset-password')
            ->assertSee('Обновить пароль')
            ->assertSee($this->token);
    }

    public function test_reset_password_handle_success()
    {
        $this->request()
            ->assertRedirect()
            ->assertSessionHas(Flash::MESSAGE_KEY, __('passwords.reset'));

        $this->user->refresh();
        $this->assertTrue(Hash::check($this->payload['password'], $this->user->password));
    }

    public function test_event_dispatched()
    {
        Event::fake();

        $this->request();

        Event::assertDispatched(PasswordReset::class);
    }

    public function test_password_reset_facade_success()
    {
        Password::shouldReceive('reset')
            ->once()
            ->withSomeOfArgs($this->payload)
            ->andReturn(Password::PASSWORD_RESET);

        $this->request();
    }
}
