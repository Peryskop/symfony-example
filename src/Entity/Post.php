<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\TimestampableTrait;

class Post implements PostInterface
{
    use TimestampableTrait;

    public const OWNER = 0;

    public const ADMIN = 1;

    private const DELETED_BY_MESSAGE = [
        self::OWNER => 'This post has been deleted.',
        self::ADMIN => 'This post has been deleted by the administrator.',
    ];

    private int $id;

    private string $description;

    private User $user;

    private ?int $deletedBy = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        if ($this->deletedBy !== null) {
            return self::DELETED_BY_MESSAGE[$this->deletedBy];
        }

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

    public function isOwner(AppUserInterface $user): bool
    {
        return $this->user === $user;
    }

    public function softDelete(AppUserInterface $user): void
    {
        $this->deletedBy = match (true) {
            $this->isOwner($user) => self::OWNER,
            $user->isAdmin() => self::ADMIN,
            default => throw new \Exception('Post soft delete exception', 500)
        };
    }
}
