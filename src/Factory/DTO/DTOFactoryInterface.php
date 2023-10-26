<?php

declare(strict_types=1);

namespace App\Factory\DTO;

use App\DTO\DTOInterface;
use Symfony\Component\HttpFoundation\Request;

interface DTOFactoryInterface
{
    public function create(Request $request): DTOInterface;

    public function supports(mixed $DTO): bool;
}
