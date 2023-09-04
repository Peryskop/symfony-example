<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\Post\PostDTO;
use App\DTO\User\UserDTO;
use Symfony\Component\HttpFoundation\Request;

final class DTOFactory
{
    public function createPostDTOFromRequest(Request $request): PostDTO
    {
        $data = json_decode((string) $request->getContent(), true);
        return new PostDTO($data);
    }

    public function createUserDTOFromRequest(Request $request): UserDTO
    {
        $data = json_decode((string) $request->getContent(), true);
        return new UserDTO($data);
    }
}
