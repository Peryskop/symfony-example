<?php

declare(strict_types=1);

namespace App\DTO\Transformer;

use App\DTO\ResponseDTOInterface;

/** @template T */
interface ResponseDTOTransformerInterface
{
    /** @param T $object */
    public function transformFromObject(mixed $object): ResponseDTOInterface;

    /**
     * @param iterable<T> $objects
     *
     * @return iterable<ResponseDTOInterface>
     */
    public function transformFromObjects(iterable $objects): iterable;
}
