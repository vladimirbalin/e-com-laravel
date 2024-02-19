<?php
declare(strict_types=1);

namespace Tests\Feature\Auth\DTOs;

use App\Http\Requests\RegisterFormRequest;
use InvalidArgumentException;
use Src\Domain\Auth\DTOs\RegisterDto;
use Src\Support\ValueObjects\Email;
use Src\Support\ValueObjects\UserName;
use Tests\TestCase;

class RegisterDtoTest extends TestCase
{
    public function test_create_from_request_success()
    {
        $payload = [
            'email' => 'valid@mail.com',
            'name' => 'name',
            'password' => 123456789
        ];

        $request = new RegisterFormRequest($payload);

        $dto = $request->getDto();

        $this->assertInstanceOf(RegisterDto::class, $dto);
        $this->assertEquals($dto->getName()->value(), $payload['name']);
        $this->assertEquals($dto->getEmail()->value(), $payload['email']);
        $this->assertEquals($dto->getPassword(), $payload['password']);
    }

    public function test_invalid_arguments()
    {
        $payload = [
            'email' => 'invalid-mail.com',
            'name' => 'n',
            'password' => 123456789
        ];

        $this->expectException(InvalidArgumentException::class);

        new RegisterDto(
            new UserName($payload['name']),
            new Email($payload['email']),
            $payload['password']
        );
    }
}
