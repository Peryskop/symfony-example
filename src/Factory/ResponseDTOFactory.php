<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\Post\PostResponseDTO;
use App\DTO\User\UserResponseDTO;
use App\Entity\Post;
use App\Entity\User;

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

    public function createUserResponseDTOFromUser(User $user): UserResponseDTO
    {
        $dto = new UserResponseDTO();

        $dto->id = $user->getId();
        $dto->email = $user->getUserIdentifier();
        $dto->firstName = $user->getFirstName();
        $dto->lastName = $user->getLastName();

        return $dto;
    }
}
