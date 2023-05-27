<?php

declare(strict_types=1);

namespace App\Paginator;

use App\DTO\PaginatedCollection;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

final class Paginator
{
    public const PAGINATOR_DEFAULT_PAGE = 1;

    public const PAGINATOR_DEFAULT_LIMIT = 20;

    public function createPaginator(
        QueryBuilder $queryBuilder,
        int $page = self::PAGINATOR_DEFAULT_PAGE,
        int $limit = self::PAGINATOR_DEFAULT_LIMIT
    ): Pagerfanta {
        $paginator = new Pagerfanta(new QueryAdapter($queryBuilder, false, false));

        $paginator->setMaxPerPage($limit);

        if ($page > $paginator->getNbPages()) {
            throw new \Exception('Page not found', Response::HTTP_NOT_FOUND);
        }

        $paginator->setCurrentPage($page);

        return $paginator;
    }

    /** @param mixed[] $collection */
    public function createPaginatedResponse(iterable $collection, Pagerfanta $paginator): PaginatedCollection
    {
        return new PaginatedCollection(
            $collection,
            $paginator->getNbResults(),
            $paginator->getCurrentPage(),
            $paginator->getNbPages()
        );
    }

    /**
     * @param mixed[] $collection
     * @param mixed[] $metadata
     */
    public function createCustomPaginatedResponse(iterable $collection, array $metadata): PaginatedCollection
    {
        return new PaginatedCollection(
            $collection,
            $metadata['nbResults'],
            $metadata['currentPage'],
            $metadata['nbPages']
        );
    }
}
