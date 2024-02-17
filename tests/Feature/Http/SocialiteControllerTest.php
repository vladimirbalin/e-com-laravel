<?php
declare(strict_types=1);

namespace Http;

use Database\Factories\UserFactory;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;
use Tests\TestCase;

class SocialiteControllerTest extends TestCase
{
    use RefreshDatabase;

    private function request(
        string $route,
        string $driver,
        bool   $withoutExceptionHandling = false
    ): TestResponse {
        $that = $withoutExceptionHandling
            ? $this->withoutExceptionHandling()
            : $this;

        return $that->get(route("socialite.$route", ['driver' => $driver]));
    }

    private function mocks(string $githubId): void
    {
        $user = $this->mock(User::class, function (MockInterface $mock) use ($githubId) {
            $mock->shouldReceive('getId')
                ->once()
                ->andReturn($githubId);
            $mock->shouldReceive('getName')
                ->once()
                ->andReturn(str()->random(25));
            $mock->shouldReceive('getEmail')
                ->once()
                ->andReturn('test@mail.com');
        });

        Socialite::shouldReceive('driver->user')
            ->once()
            ->andReturn($user);
    }

    public function test_redirect_success()
    {
        $this->request('redirect', 'github')
            ->assertValid()
            ->assertRedirect();
    }

    public function test_redirect_driver_invalid()
    {
        $this->expectException(DomainException::class);

        $this->request('redirect', 'invalid', true);
    }

    public function test_callback_driver_invalid()
    {
        $this->expectException(DomainException::class);

        $this->request('callback', 'invalid', true);
    }

    public function test_callback_success()
    {
        $ghId = str()->random(10);
        $this->mocks($ghId);

        $this->request('callback', 'github')
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', ['github_id' => $ghId]);
    }

    public function test_callback_auth_with_existing_user_success()
    {
        $ghId = str()->random(10);
        $this->mocks($ghId);
        $user = UserFactory::new(['github_id' => $ghId])->create();

        $this->request('callback', 'github')
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }
}
