<?php

declare(strict_types=1);

namespace App\Factory\ResponseDTO;

use App\DTO\Post\PostResponseDTO;
use App\DTO\ResponseDTOInterface;
use App\Entity\EntityInterface;
use App\Entity\Post;
use App\Entity\PostInterface;

final readonly class PostResponseDTOFactory implements ResponseDTOFactoryInterface
{
    public function __construct(
        private ResponseDTOFactoryInterface $userResponseDTOFactory
    ) {
    }

    /** @param PostInterface $entity */
    public function create(EntityInterface $entity): ResponseDTOInterface
    {
        $dto = new PostResponseDTO();

        $dto->id = $entity->getId();
        $dto->description = $entity->getDescription();
        $dto->createdAt = $entity->getCreatedAt()->format('Y-m-d H:i:s');
        $dto->updatedAt = $entity->getUpdatedAt()->format('Y-m-d H:i:s');
        $dto->user = $this->userResponseDTOFactory->create($entity->getUser());

        return $dto;
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === Post::class;
    }
}
