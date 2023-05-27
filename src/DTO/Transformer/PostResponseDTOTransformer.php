<?php

declare(strict_types=1);

namespace App\DTO\Transformer;

use App\DTO\Post\PostResponseDTO;
use App\Factory\ResponseDTOFactory;

final class PostResponseDTOTransformer extends AbstractResponseDTOTransformer
{
    public function __construct(
        private readonly ResponseDTOFactory $responseDTOFactory,
    ) {
    }

    public function transformFromObject(mixed $object): PostResponseDTO
    {
        return $this->responseDTOFactory->createPostResponseDTOFromPost($object);
    }
}
