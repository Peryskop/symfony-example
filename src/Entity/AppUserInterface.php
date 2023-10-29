<?php

declare(strict_types=1);

namespace App\Entity;

interface AppUserInterface extends EntityInterface
{
    public function getId(): int;

    public function setEmail(string $email): void;

    public function getPassword(): string;

    public function setPassword(#[\SensitiveParameter] string $password): void;

    /** @return string[] */
    public function getRoles(): array;

    public function getSalt(): ?string;

    public function getUserIdentifier(): string;

    public function getFirstName(): string;

    public function setFirstName(string $firstName): void;

    public function getLastName(): string;

    public function setLastName(string $lastName): void;

    public function addAdminRole(): void;

    public function isAdmin(): bool;
}
