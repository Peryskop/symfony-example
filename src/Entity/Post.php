<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\TimestampableTrait;

class Post implements PostInterface
{
    use TimestampableTrait;

    private int $id;

    private string $description;

    private User $user;

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

    public function getUser(): AppUserInterface
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
