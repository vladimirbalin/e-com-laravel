<?php
declare(strict_types=1);

namespace Tests\Feature\Http;

use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    private function userFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function test_login_show()
    {
        return $this->get(route('login.show'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_login_mail_show()
    {
        return $this->get(route('login.mail.show'))
            ->assertOk()
            ->assertViewIs('auth.login-mail');
    }

    public function test_login_handle_success(): void
    {
        Event::fake();

        $user = $this->userFactory()->withEmail('valid@mail.com')->create();

        $payload = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->post(route('login.handle'), $payload);

        $response->assertRedirect();

        Event::assertDispatched(Authenticated::class);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    #[DataProvider('provider_invalid_credentials')]
    public function test_login_post_invalid(string $email, string $password): void
    {
        Event::fake();

        $this->userFactory()->withEmail('valid@mail.com')->create();

        $this->post(route('login.handle'), ['email' => $email, 'password' => $password])
            ->assertStatus(302)
            ->assertSessionHasErrors('email');

        Event::assertNotDispatched(Authenticated::class);

        $this->assertGuest();
    }

    public static function provider_invalid_credentials(): array
    {
        return [
            ['invalid-email-example-com', 'password'],
            ['valid@mail.com', 'invalid-password'],
            ['not-registered@mail.com', 'password'],
            ['not-registered@mail.com', 'invalid-password'],
        ];
    }

    #[DataProvider('provider_invalid_methods')]
    public function test_login_post_invalid_method(string $method): void
    {
        $user = $this->userFactory()->withEmail('valid@mail.com')->create();
        $payload = [
            'email' => $user->email,
            'password' => 'password',
        ];
        $this->{$method}(route('login.handle'), $payload)
            ->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);

        $this->assertGuest();
    }

    public static function provider_invalid_methods(): array
    {
        return [['patch'], ['put'], ['delete']];
    }

    public function test_logout_success()
    {
        $user = $this->userFactory()->create();
        $this->actingAs($user);

        $this->delete(route('logout'))
            ->assertRedirectToRoute('home');
        $this->assertGuest();
    }
}
