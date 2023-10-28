<?php

declare(strict_types=1);

namespace App\DTO\Post;

use App\DTO\DTOInterface;

interface PostDTOInterface extends DTOInterface
{
    public function getDescription(): ?string;
}
