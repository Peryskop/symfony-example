<?php

declare(strict_types=1);

namespace App\DTO\User;

use App\Trimmer\Trimmer;

final readonly class UserDTO implements UserDTOInterface
{
    /** @param mixed[]|null $data */
    public function __construct(?array $data = [])
    {
        $this->email = Trimmer::trim($data['email'] ?? null);
        $this->password = $data['password'] ?? null;
        $this->firstName = Trimmer::trim($data['firstName'] ?? null);
        $this->lastName = Trimmer::trim($data['lastName'] ?? null);
    }

    private ?string $email;

    private ?string $password;

    private ?string $firstName;

    private ?string $lastName;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }
}
