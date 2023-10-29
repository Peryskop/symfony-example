<?php

declare(strict_types=1);

namespace App\Remover\Entity;

use App\Checker\UserChecker;
use App\Entity\Comment;
use App\Entity\CommentInterface;
use App\Entity\EntityInterface;
use App\Entity\PostInterface;
use App\Repository\CommentRepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CommentRemover implements EntityRemoverInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private Security $security
    ) {
    }

    /** @param PostInterface $entity */
    public function softDelete(EntityInterface $entity): void
    {
        $entity->softDelete(UserChecker::check($this->security->getUser()));
        $this->commentRepository->flush();
    }

    /** @param CommentInterface $entity */
    public function hardDelete(EntityInterface $entity): void
    {
        $this->commentRepository->delete($entity);
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === Comment::class;
    }
}
