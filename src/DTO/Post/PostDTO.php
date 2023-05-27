<?php

declare(strict_types=1);

namespace App\DTO\Post;

final readonly class PostDTO
{
    /** @param mixed[]|null $postData */
    public function __construct(?array $postData)
    {
        $this->description = $postData['description'] ?? null;
    }

    public ?string $description;
}
