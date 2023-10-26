<?php

declare(strict_types=1);

namespace App\DTO\Post;

use App\DTO\DTOInterface;

final readonly class PostDTO implements DTOInterface
{
    /** @param mixed[]|null $data */
    public function __construct(?array $data = [])
    {
        $this->description = $data['description'] ?? null;
    }

    public ?string $description;
}
