<?php

declare(strict_types=1);

namespace App\DTO\Post;

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
}
