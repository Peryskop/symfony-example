<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\EntityInterface;
use App\Entity\PostInterface;
use Doctrine\ORM\QueryBuilder;

interface CommentRepositoryInterface
{
    public function save(EntityInterface $comment): void;

    public function flush(): void;

    public function delete(Comment $comment): void;

    /** @param mixed[] $params */
    public function findByPost(array $params, PostInterface $post): QueryBuilder;

    public function findById(int $commentId): Comment;
}
