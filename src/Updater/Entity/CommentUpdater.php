<?php

declare(strict_types=1);

namespace App\Updater\Entity;

use App\DTO\Comment\CommentDTOInterface;
use App\DTO\DTOInterface;
use App\Entity\Comment;
use App\Entity\CommentInterface;
use App\Entity\EntityInterface;

final class CommentUpdater implements EntityUpdaterInterface
{
    /**
     * @param CommentInterface $entity
     * @param CommentDTOInterface $DTO
     */
    public function update(EntityInterface $entity, DTOInterface $DTO): void
    {
        $entity->setContent($DTO->getContent());
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === Comment::class;
    }
}
