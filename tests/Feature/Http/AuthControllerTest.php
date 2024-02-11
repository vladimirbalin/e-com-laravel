<?php

namespace Http;

use App\Listeners\RegisteredListener;
use App\Models\User;
use App\Notifications\WelcomeUserNotification;
use App\Support\Flash\Flash;
use App\Support\Flash\FlashMessage;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_register()
    {
        return $this->get(route('register'))
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    public function test_register_mail()
    {
        return $this->get(route('register-mail'))
            ->assertOk()
            ->assertViewIs('auth.register-mail');
    }

    public function test_login()
    {
        return $this->get(route('login'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_login_post_success(): void
    {
        Event::fake();

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

        Event::assertListening(Registered::class, RegisteredListener::class);
        Event::assertDispatched(Registered::class);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_register_post_success(): void
    {
        Event::fake();

        $password = bcrypt(Str::random(8));

        $payload = [
            'name' => 'valid name',
            'email' => 'valid-email@mail.com',
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->post(route('register-post'), $payload);
        $response->assertValid();

        Event::assertDispatched(Registered::class);

        $user = User::firstWhere('email', $payload['email']);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('home'));
    }

    public function test_login_mail()
    {
        return $this->get(route('login-mail'))
            ->assertOk()
            ->assertViewIs('auth.login-mail');
    }

    public function test_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->delete(route('logout'))
            ->assertRedirectToRoute('home');
        $this->assertGuest();
    }

    public function test_forgot_password()
    {
        return $this->get(route('forgot-password'))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_forgot_password_post()
    {
        $user = User::factory()->create();
        $payload = ['email' => $user->email];

        $response = $this->post(route('forgot-password-post'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas(Flash::MESSAGE_KEY, 'Ссылка на сброс пароля была отправлена.');
        $this->assertGuest();
    }

    public function test_reset_password(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $this->get(route('password.reset', ['token' => $token]))
            ->assertOk()
            ->assertViewIs('auth.reset-password')
            ->assertSee('Обновить пароль')
            ->assertSee($token);
    }

    public function test_reset_password_post()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);
        $this->assertTrue(Password::tokenExists($user, $token));

        $newPassword = Str::random(8);
        $payload = [
            'email' => $user->email,
            'token' => $token,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ];

        $this->post(route('password.update'), $payload)
            ->assertRedirect()
            ->assertSessionHas(Flash::MESSAGE_KEY, __('passwords.reset'));

//        Event::fake();
//        Event::assertDispatched(PasswordReset::class);

        $user->refresh();
        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

}
