<?php

declare(strict_types=1);

namespace App\Entity;

interface PostInterface extends EntityInterface
{
    public function getId(): int;

    public function getDescription(): string;

    public function setDescription(string $description): void;

    public function getUser(): AppUserInterface;

    public function setUser(User $user): void;

    public function getCreatedAt(): \DateTimeImmutable;

    public function getUpdatedAt(): \DateTimeImmutable;

    public function updateTimestamps(): void;
}
