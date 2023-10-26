<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\DTO\DTOInterface;
use App\Entity\EntityInterface;

interface CompositeEntityFactoryInterface
{
    public function create(DTOInterface $DTO): EntityInterface;
}
