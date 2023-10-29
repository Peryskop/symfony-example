<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use App\Entity\PostInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;

interface PostRepositoryInterface extends ObjectRepository
{
    public function save(PostInterface $post): void;

    public function flush(): void;

    public function delete(PostInterface $post): void;

    /** @param mixed[] $params */
    public function findByParams(array $params): QueryBuilder;

    public function findById(int $postId): Post;
}
