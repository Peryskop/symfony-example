<?php

declare(strict_types=1);

namespace App\DTO\Post;

final readonly class PostDTO
{
    /** @param mixed[]|null $data */
    public function __construct(?array $data = [])
    {
        $this->description = $data['description'] ?? null;
    }

    public ?string $description;
}
