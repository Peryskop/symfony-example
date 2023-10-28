<?php

declare(strict_types=1);

namespace App\Factory\ResponseDTO;

use App\DTO\Comment\CommentResponseDTO;
use App\DTO\ResponseDTOInterface;
use App\Entity\Comment;
use App\Entity\CommentInterface;
use App\Entity\EntityInterface;

final readonly class CommentResponseDTOFactory implements ResponseDTOFactoryInterface
{
    public function __construct(
        private ResponseDTOFactoryInterface $userResponseDTOFactory
    ) {
    }

    /** @param CommentInterface $entity */
    public function create(EntityInterface $entity): ResponseDTOInterface
    {
        $dto = new CommentResponseDTO();

        $dto->id = $entity->getId();
        $dto->content = $entity->getContent();
        $dto->createdAt = $entity->getCreatedAt()->format('Y-m-d H:i:s');
        $dto->updatedAt = $entity->getUpdatedAt()->format('Y-m-d H:i:s');
        $dto->user = $this->userResponseDTOFactory->create($entity->getUser());

        return $dto;
    }

    public function supports(EntityInterface $entity): bool
    {
        return $entity::class === Comment::class;
    }
}
