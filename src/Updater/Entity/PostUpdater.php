<?php

declare(strict_types=1);

namespace App\Updater\Entity;

use App\DTO\DTOInterface;
use App\DTO\Post\PostDTOInterface;
use App\Entity\EntityInterface;
use App\Entity\Post;
use App\Entity\PostInterface;

final class PostUpdater implements EntityUpdaterInterface
{
    /**
     * @param PostInterface $entity
     * @param PostDTOInterface $DTO
     */
    public function update(EntityInterface $entity, DTOInterface $DTO): void
    {
        $entity->setDescription($DTO->getDescription());
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === Post::class;
    }
}
