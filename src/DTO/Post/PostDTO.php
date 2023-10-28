<?php

declare(strict_types=1);

namespace App\DTO\Post;

final readonly class PostDTO implements PostDTOInterface
{
    /** @param mixed[]|null $data */
    public function __construct(?array $data = [])
    {
        $this->description = $data['description'] ?? null;
    }

    private ?string $description;

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
