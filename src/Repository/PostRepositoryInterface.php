<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityInterface;
use App\Entity\Post;
use Doctrine\ORM\QueryBuilder;

interface PostRepositoryInterface
{
    public function save(EntityInterface $post): void;

    public function flush(): void;

    public function delete(Post $post): void;

    /** @param mixed[] $params */
    public function findByParams(array $params): QueryBuilder;

    public function findById(int $postId): Post;
}
