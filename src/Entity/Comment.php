<?php

declare(strict_types=1);

namespace App\Entity;

use App\Trait\TimestampableTrait;

class Comment implements CommentInterface
{
    use TimestampableTrait;

    private int $id;

    private string $content;

    private User $user;

    private Post $post;

    private ?Comment $comment = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
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
}
