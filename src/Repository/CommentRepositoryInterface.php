<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\CommentInterface;
use App\Entity\PostInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;

interface CommentRepositoryInterface extends ObjectRepository
{
    public function save(CommentInterface $comment): void;

    public function flush(): void;

    public function delete(CommentInterface $comment): void;

    /** @param mixed[] $params */
    public function findByPost(array $params, PostInterface $post): QueryBuilder;

    public function findById(int $commentId): Comment;
}
