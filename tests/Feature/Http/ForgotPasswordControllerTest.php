<?php
declare(strict_types=1);

namespace Tests\Feature\Http;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Support\Flash\Flash;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    private function userFactory(): UserFactory
    {
        return UserFactory::new();
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
        $response->assertSessionHas(Flash::MESSAGE_KEY, __('passwords.sent'));
        $this->assertGuest();
    }
}
