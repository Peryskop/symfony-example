<?php

declare(strict_types=1);

namespace App\Updater\Entity;

use App\DTO\DTOInterface;
use App\DTO\User\UserDTOInterface;
use App\Entity\AppUserInterface;
use App\Entity\EntityInterface;
use App\Entity\User;

final readonly class UserUpdater implements EntityUpdaterInterface
{
    /**
     * @param AppUserInterface $entity
     * @param UserDTOInterface $DTO
     */
    public function update(EntityInterface $entity, DTOInterface $DTO): void
    {
        $entity->setFirstName($DTO->getFirstName());
        $entity->setLastName($DTO->getLastName());
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === User::class;
    }
}
