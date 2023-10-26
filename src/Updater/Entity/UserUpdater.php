<?php

declare(strict_types=1);

namespace App\Updater\Entity;

use App\DTO\DTOInterface;
use App\DTO\User\UserDTO;
use App\Entity\EntityInterface;
use App\Entity\User;

final readonly class UserUpdater implements EntityUpdaterInterface
{
    /**
     * @param User $entity
     * @param UserDTO $DTO
     */
    public function update(EntityInterface $entity, DTOInterface $DTO): void
    {
        $entity->setFirstName($DTO->firstName);
        $entity->setLastName($DTO->lastName);
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === User::class;
    }
}
