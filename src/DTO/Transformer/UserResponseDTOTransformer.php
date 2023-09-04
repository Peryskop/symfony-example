<?php

declare(strict_types=1);

namespace App\DTO\Transformer;

use App\DTO\User\UserResponseDTO;
use App\Factory\ResponseDTOFactory;

final class UserResponseDTOTransformer extends AbstractResponseDTOTransformer
{
    public function __construct(
        private readonly ResponseDTOFactory $responseDTOFactory
    ) {
    }

    public function transformFromObject(mixed $object): UserResponseDTO
    {
        return $this->responseDTOFactory->createUserResponseDTOFromUser($object);
    }
}
