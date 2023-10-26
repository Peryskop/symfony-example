<?php

declare(strict_types=1);

namespace App\Updater\Entity;

use App\DTO\DTOInterface;
use App\Entity\EntityInterface;

interface CompositeEntityUpdaterInterface
{
    public function update(EntityInterface $entity, DTOInterface $DTO): void;
}
