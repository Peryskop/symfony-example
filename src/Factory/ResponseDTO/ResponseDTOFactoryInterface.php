<?php

declare(strict_types=1);

namespace App\Factory\ResponseDTO;

use App\DTO\ResponseDTOInterface;
use App\Entity\EntityInterface;

interface ResponseDTOFactoryInterface
{
    public function create(EntityInterface $entity): ResponseDTOInterface;

    public function supports(EntityInterface $entity): bool;
}
