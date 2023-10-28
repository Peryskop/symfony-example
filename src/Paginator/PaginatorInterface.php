<?php

declare(strict_types=1);

namespace App\Paginator;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Pagerfanta;

interface PaginatorInterface
{
    public function createPaginator(
        QueryBuilder $queryBuilder,
        int $page,
        int $limit
    ): Pagerfanta;

    /** @param mixed[] $collection */
    public function createPaginatedResponse(iterable $collection, Pagerfanta $paginator): PaginatedCollection;

    /**
     * @param mixed[] $collection
     * @param mixed[] $metadata
     */
    public function createCustomPaginatedResponse(iterable $collection, array $metadata): PaginatedCollection;
}
