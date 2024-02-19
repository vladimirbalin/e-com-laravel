<?php
declare(strict_types=1);

namespace Tests\Feature\Auth\Actions;

use Src\Domain\Auth\Contracts\Register;
use Src\Domain\Auth\DTOs\RegisterDto;
use Src\Support\ValueObjects\Email;
use Src\Support\ValueObjects\UserName;
use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    public function test_success()
    {
        $email = 'valid@mail.com';
        $this->assertDatabaseMissing('users', [
            'email' => $email
        ]);

        $action = app(Register::class);

        $action->handle(new RegisterDto(new UserName('name'), new Email($email), '12345678'));

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);
    }
}
