<?php

namespace Http;

use App\Listeners\RegisteredListener;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Src\Domain\Auth\Models\User;
use Src\Support\Flash\Flash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private function userFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function testBasic()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_register_show()
    {
        return $this->get(route('register.show'))
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    public function test_register_mail_show()
    {
        return $this->get(route('register.mail.show'))
            ->assertOk()
            ->assertViewIs('auth.register-mail');
    }

    public function test_login_show()
    {
        return $this->get(route('login.show'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_login_post_success(): void
    {
        Event::fake();

        $user = $this->userFactory()->withEmail('valid@mail.com')->create();

        $payload = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('login.handle'), $payload);

        $response->assertRedirect();

        Event::assertDispatched(Authenticated::class);

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

        $response = $this->post(route('register.handle'), $payload);
        $response->assertValid();

        Event::assertDispatched(Registered::class);

        $user = User::firstWhere('email', $payload['email']);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('home'));
    }

    public function test_login_mail_show()
    {
        return $this->get(route('login.mail.show'))
            ->assertOk()
            ->assertViewIs('auth.login-mail');
    }

    public function test_logout()
    {
        $user = $this->userFactory()->create();
        $this->actingAs($user);

        $this->delete(route('logout'))
            ->assertRedirectToRoute('home');
        $this->assertGuest();
    }

    public function test_forgot_password()
    {
        return $this->get(route('forgot-password.show'))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_forgot_password_post()
    {
        $user = $this->userFactory()->create();
        $payload = ['email' => $user->email];

        $response = $this->post(route('forgot-password.handle'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas(Flash::MESSAGE_KEY, 'Ссылка на сброс пароля была отправлена.');
        $this->assertGuest();
    }

    public function test_reset_password(): void
    {
        $user = $this->userFactory()->create();
        $token = Password::createToken($user);

        $this->get(route('password.reset', ['token' => $token]))
            ->assertOk()
            ->assertViewIs('auth.reset-password')
            ->assertSee('Обновить пароль')
            ->assertSee($token);
    }

    public function test_reset_password_post()
    {
        $user = $this->userFactory()->create();
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
