<?php

declare(strict_types=1);

namespace App\DTO;

final class PaginatedCollection
{
    /** @param mixed[] $items */
    public function __construct(
        public iterable $items,
        public int $total,
        public int $page,
        public int $pagesTotal,
    ) {
    }
}
