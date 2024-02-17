<?php
declare(strict_types=1);

namespace Tests\Feature\Http;

use App\Listeners\RegisteredListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Src\Domain\Auth\Models\User;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $payload = [];

    protected function setUp(): void
    {
        parent::setUp();

        $password = bcrypt(Str::random(8));

        $this->payload = [
            'name' => 'valid name',
            'email' => 'valid-email@mail.com',
            'password' => $password,
            'password_confirmation' => $password,
        ];
    }

    private function request(): TestResponse
    {
        return $this->post(route('register.handle'), $this->payload);
    }

    public function test_register_show()
    {
        return $this->get(route('register.show'))
            ->assertOk()
            ->assertSee(__('Register'))
            ->assertViewIs('auth.register');
    }

    public function test_register_mail_show()
    {
        return $this->get(route('register.mail.show'))
            ->assertOk()
            ->assertSee(__('Register'))
            ->assertViewIs('auth.register-mail');
    }

    public function test_validation_success()
    {
        $this->request()->assertValid();
    }

    public function test_register_post_success(): void
    {
        $response = $this->request();

        $user = User::firstWhere('email', $this->payload['email']);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('home'));
    }

    public function test_event_dispatched_and_listener_listen()
    {
        Event::fake();

        $this->request();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, RegisteredListener::class);
    }

    public function test_password_confirmation_invalid()
    {
        $this->payload['password_confirmation'] = 'invalid-password-confirm';

        $passwordAttributeName = __('validation.attributes.password');

        $this->request()->assertInvalid([
            'password' => __('validation.confirmed',
                ['attribute' => $passwordAttributeName]
            )]);
    }

    public function test_email_invalid()
    {
        $this->payload['email'] = 'invalid-email-com';

        $emailAttributeName = __('validation.attributes.email');

        $this->request()->assertInvalid([
            'email' => __('validation.email',
                ['attribute' => $emailAttributeName])
        ]);
    }

    public function test_password_invalid()
    {
        $this->payload['password'] = '123';
        $this->payload['password_confirmation'] = '123';

        $passwordAttributeName = __('validation.attributes.password');

        $this->request()->assertInvalid([
            'password' => __('validation.min.string',
                ['attribute' => $passwordAttributeName, 'min' => 8])
        ]);
    }
}
