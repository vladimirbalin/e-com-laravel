<?php

declare(strict_types=1);

namespace Src\Domain\Auth\DTOs;

use App\Http\Requests\RegisterFormRequest;
use Src\Support\ValueObjects\Email;
use Src\Support\ValueObjects\UserName;

readonly class RegisterDto
{
    public function __construct(
        public UserName $name,
        public Email    $email,
        public string   $password,
    ) {}

    public static function make(UserName $name, Email $email, string $password): self
    {
        return new self($name, $email, $password);
    }

    public static function fromRequest(RegisterFormRequest $request): self
    {
        return new self(
            UserName::fromString($request->input('name')),
            Email::fromString($request->input('email')),
            $request->input('password'),
        );
    }
}
