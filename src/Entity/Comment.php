<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\TimestampableTrait;

class Comment implements CommentInterface
{
    use TimestampableTrait;

    public const OWNER = 0;

    public const ADMIN = 1;

    public const POST_OWNER = 2;

    private const DELETED_BY_MESSAGE = [
        self::OWNER => 'This comment has been deleted.',
        self::ADMIN => 'This comment has been deleted by the administrator.',
        self::POST_OWNER => 'This comment has been deleted by the author of the post.',
    ];

    private int $id;

    private string $content;

    private User $user;

    private Post $post;

    private ?Comment $comment = null;

    private ?int $deletedBy = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        if ($this->deletedBy !== null) {
            return self::DELETED_BY_MESSAGE[$this->deletedBy];
        }

        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getUser(): AppUserInterface
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getPost(): PostInterface
    {
        return $this->post;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    public function getComment(): ?CommentInterface
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): void
    {
        $this->comment = $comment;
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
            $this->post->isOwner($user) => self::POST_OWNER,
            default => throw new \Exception('Comment soft delete exception', 500)
        };
    }
}
