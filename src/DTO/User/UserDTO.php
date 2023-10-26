<?php

declare(strict_types=1);

namespace App\DTO\User;

use App\DTO\DTOInterface;
use App\Trimmer\Trimmer;

final readonly class UserDTO implements DTOInterface
{
    /** @param mixed[]|null $data */
    public function __construct(?array $data = [])
    {
        $this->email = Trimmer::trim($data['email'] ?? null);
        $this->password = $data['password'] ?? null;
        $this->firstName = Trimmer::trim($data['firstName'] ?? null);
        $this->lastName = Trimmer::trim($data['lastName'] ?? null);
    }

    public ?string $email;

    public ?string $password;

    public ?string $firstName;

    public ?string $lastName;
}
