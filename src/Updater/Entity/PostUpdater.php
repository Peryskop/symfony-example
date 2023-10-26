<?php

declare(strict_types=1);

namespace App\Updater\Entity;

use App\DTO\DTOInterface;
use App\DTO\Post\PostDTO;
use App\Entity\EntityInterface;
use App\Entity\Post;

final class PostUpdater implements EntityUpdaterInterface
{
    /**
     * @param Post $entity
     * @param PostDTO $DTO
     */
    public function update(EntityInterface $entity, DTOInterface $DTO): void
    {
        $entity->setDescription($DTO->description);
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === Post::class;
    }
}
