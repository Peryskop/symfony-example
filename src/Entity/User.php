<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\TimestampableTrait;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements PasswordAuthenticatedUserInterface, UserInterface, AppUserInterface
{
    use TimestampableTrait;

    public const USER = 'ROLE_USER';

    public const ADMIN = 'ROLE_ADMIN';

    private int $id;

    private string $email;

    private string $password;

    private string $firstName;

    private string $lastName;

    /** @var string[] $roles */
    private array $roles = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(#[\SensitiveParameter] string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = self::USER;

        return array_unique($roles);
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function addAdminRole(): void
    {
        if (! in_array(self::ADMIN, $this->roles)) {
            $this->roles[] = self::ADMIN;
        }
    }
}
