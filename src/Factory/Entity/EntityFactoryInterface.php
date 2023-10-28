<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\DTO\DTOInterface;
use App\Entity\EntityInterface;

/** @template T */
interface EntityFactoryInterface
{
    /**
     * @param DTOInterface $DTO
     * @return EntityInterface<T>
     */
    public function create(DTOInterface $DTO): EntityInterface;

    public function supports(DTOInterface $DTO): bool;
}
