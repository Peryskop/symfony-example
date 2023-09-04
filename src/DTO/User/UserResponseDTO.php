<?php

declare(strict_types=1);

namespace App\DTO\User;

use JMS\Serializer\Annotation as Serialization;

final class UserResponseDTO
{
    #[Serialization\Groups(['user:read'])]
    public int $id;

    #[Serialization\Groups(['user:read'])]
    public string $email;

    #[Serialization\Groups(['user:read'])]
    public string $firstName;

    #[Serialization\Groups(['user:read'])]
    public string $lastName;
}
