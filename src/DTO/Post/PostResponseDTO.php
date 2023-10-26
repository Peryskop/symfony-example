<?php

declare(strict_types=1);

namespace App\DTO\Post;

use App\DTO\ResponseDTOInterface;
use JMS\Serializer\Annotation as Serialization;

final class PostResponseDTO implements ResponseDTOInterface
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
    public ResponseDTOInterface $user;
}
