<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\DTO\DTOInterface;
use App\Entity\EntityInterface;

interface EntityFactoryInterface
{
    /**
     * @param DTOInterface $DTO
     */
    public function create(DTOInterface $DTO): EntityInterface;

    public function supports(DTOInterface $DTO): bool;
}
