<?php

declare(strict_types=1);

namespace App\Factory\DTO;

use App\DTO\DTOInterface;
use App\DTO\User\UserDTO;
use Symfony\Component\HttpFoundation\Request;

final class UserDTOFactory implements DTOFactoryInterface
{
    public function create(Request $request): DTOInterface
    {
        $data = json_decode((string) $request->getContent(), true);
        return new UserDTO($data);
    }

    public function supports(DTOInterface $DTO): bool
    {
        return $DTO::class === UserDTO::class;
    }
}
