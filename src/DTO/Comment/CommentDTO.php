<?php

declare(strict_types=1);

namespace App\DTO\Comment;

final readonly class CommentDTO implements CommentDTOInterface
{
    /** @param mixed[]|null $data */
    public function __construct(?array $data = [])
    {
        $this->postId = $data['postId'] ?? null;
        $this->commentId = $data['commentId'] ?? null;
        $this->content = $data['content'] ?? null;
    }

    public ?int $postId;

    public ?int $commentId;

    public ?string $content;

    public function getPostId(): ?int
    {
        return $this->postId;
    }

    public function getCommentId(): ?int
    {
        return $this->commentId;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
}
