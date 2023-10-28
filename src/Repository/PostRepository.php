<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityInterface;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(
        readonly ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Post::class);
    }

    public function save(EntityInterface $post): void
    {
        $this->_em->persist($post);
        $this->flush();
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function delete(Post $post): void
    {
        $this->_em->remove($post);
        $this->flush();
    }

    public function findByParams(array $params): QueryBuilder
    {
        $order = 'DESC';
        if (key_exists('order', $params) && $params['order'] === 'ASC') {
            $order = 'ASC';
        }
        return $this->createQueryBuilder('o')
            ->orderBy('o.createdAt', $order)
        ;
    }

    public function findById(int $postId): Post
    {
        /** @var Post|null $post */
        $post = $this->find($postId);

        if (! $post) {
            throw new NotFoundHttpException('Post not found');
        }

        return $post;
    }
}
