<?php

declare(strict_types=1);

namespace App\DTO\Transformer;

/** @template T */
interface ResponseDTOTransformerInterface
{
    /**
     * @param T $object
     *
     * @return T
     */
    public function transformFromObject(mixed $object): mixed;

    /**
     * @param iterable<T> $objects
     *
     * @return iterable<T>
     */
    public function transformFromObjects(iterable $objects): iterable;
}
