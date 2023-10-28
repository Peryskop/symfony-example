<?php

declare(strict_types=1);

namespace App\DTO\Comment;

use App\DTO\ResponseDTOInterface;
use JMS\Serializer\Annotation as Serialization;

final class CommentResponseDTO implements ResponseDTOInterface
{
    #[Serialization\Groups(['comment:read'])]
    public int $id;

    #[Serialization\Groups(['comment:read'])]
    public string $content;

    #[Serialization\Groups(['comment:read'])]
    public string $createdAt;

    #[Serialization\Groups(['comment:read'])]
    public string $updatedAt;

    #[Serialization\Groups(['comment:read'])]
    public ResponseDTOInterface $user;
}
