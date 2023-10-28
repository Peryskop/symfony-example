<?php

declare(strict_types=1);

namespace App\Factory\ResponseDTO;

use App\DTO\ResponseDTOInterface;
use App\DTO\User\UserResponseDTO;
use App\Entity\AppUserInterface;
use App\Entity\EntityInterface;
use App\Entity\User;

final class UserResponseDTOFactory implements ResponseDTOFactoryInterface
{
    /** @param AppUserInterface $entity */
    public function create(EntityInterface $entity): ResponseDTOInterface
    {
        $dto = new UserResponseDTO();

        $dto->id = $entity->getId();
        $dto->email = $entity->getUserIdentifier();
        $dto->firstName = $entity->getFirstName();
        $dto->lastName = $entity->getLastName();

        return $dto;
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === User::class;
    }
}
