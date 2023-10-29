<?php

declare(strict_types=1);

namespace App\Remover\Entity;

use App\Checker\UserChecker;
use App\Entity\EntityInterface;
use App\Entity\Post;
use App\Entity\PostInterface;
use App\Repository\PostRepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class PostRemover implements EntityRemoverInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private Security $security
    ) {
    }

    /** @param PostInterface $entity */
    public function softDelete(EntityInterface $entity): void
    {
        $entity->softDelete(UserChecker::check($this->security->getUser()));
        $this->postRepository->flush();
    }

    /** @param PostInterface $entity */
    public function hardDelete(EntityInterface $entity): void
    {
        $this->postRepository->delete($entity);
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === Post::class;
    }
}
