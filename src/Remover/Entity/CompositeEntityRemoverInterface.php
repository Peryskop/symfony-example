<?php

declare(strict_types=1);

namespace App\Remover\Entity;

use App\Entity\EntityInterface;

interface CompositeEntityRemoverInterface
{
    public function softDelete(EntityInterface $entity): void;

    public function hardDelete(EntityInterface $entity): void;
}
