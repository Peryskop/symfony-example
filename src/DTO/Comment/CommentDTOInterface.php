<?php

declare(strict_types=1);

namespace App\DTO\Comment;

use App\DTO\DTOInterface;

interface CommentDTOInterface extends DTOInterface
{
    public function getPostId(): ?int;

    public function getCommentId(): ?int;

    public function getContent(): ?string;
}
