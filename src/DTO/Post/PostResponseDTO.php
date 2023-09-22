<?php

declare(strict_types=1);

namespace App\DTO\Post;

use App\DTO\User\UserResponseDTO;
use JMS\Serializer\Annotation as Serialization;

final class PostResponseDTO
{
    #[Serialization\Groups(['post:read'])]
    public int $id;

    #[Serialization\Groups(['post:read'])]
    public string $description;

    #[Serialization\Groups(['post:read'])]
    public string $createdAt;

    #[Serialization\Groups(['post:read'])]
    public string $updatedAt;

    #[Serialization\Groups(['post:read'])]
    public UserResponseDTO $user;
}
