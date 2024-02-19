<?php
declare(strict_types=1);

namespace Tests\Feature\Auth\DTOs;

use App\Http\Requests\RegisterFormRequest;
use Src\Domain\Auth\DTOs\RegisterDto;
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
        $this->assertEquals($dto->getName(), $payload['name']);
        $this->assertEquals($dto->getEmail(), $payload['email']);
        $this->assertEquals($dto->getPassword(), $payload['password']);
    }
}
