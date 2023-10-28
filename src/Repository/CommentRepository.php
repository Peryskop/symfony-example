<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\EntityInterface;
use App\Entity\PostInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CommentRepository extends ServiceEntityRepository implements CommentRepositoryInterface
{
    public function __construct(
        readonly ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Comment::class);
    }

    public function save(EntityInterface $comment): void
    {
        $this->_em->persist($comment);
        $this->flush();
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function delete(Comment $comment): void
    {
        $this->_em->remove($comment);
        $this->flush();
    }

    public function findByPost(array $params, PostInterface $post): QueryBuilder
    {
        $qb = $this->createQueryBuilder('o')
            ->andWhere('o.post = :post')
            ->setParameter('post', $post)
        ;

        $order = 'DESC';
        if (key_exists('order', $params) && $params['order'] === 'ASC') {
            $order = 'ASC';
        }
        return $qb->orderBy('o.createdAt', $order)
        ;
    }

    public function findById(int $commentId): Comment
    {
        /** @var Comment|null $comment */
        $comment = $this->find($commentId);

        if (! $comment) {
            throw new NotFoundHttpException('Comment not found');
        }

        return $comment;
    }
}
