<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\Post\PostResponseDTO;
use App\Entity\Post;

final class ResponseDTOFactory
{
    public function createPostResponseDTOFromPost(Post $post): PostResponseDTO
    {
        $dto = new PostResponseDTO();

        $dto->id = $post->getId();
        $dto->description = $post->getDescription();
        $dto->createdAt = $post->getCreatedAt()->format('Y-m-d H:i:s');
        $dto->updatedAt = $post->getUpdatedAt()->format('Y-m-d H:i:s');

        return $dto;
    }
}
