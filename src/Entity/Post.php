<?php

declare(strict_types=1);

namespace App\Entity;

class Post
{
    private int $id;

    private string $description;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateTimestamps(): void
    {
        $utcTimeZone = new \DateTimeZone('UTC');

        $this->updatedAt = new \DateTimeImmutable(timezone: $utcTimeZone);
        if (! isset($this->createdAt)) {
            $this->createdAt = new \DateTimeImmutable(timezone: $utcTimeZone);
        }
    }
}
