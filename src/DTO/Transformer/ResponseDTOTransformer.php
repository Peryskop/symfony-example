<?php

declare(strict_types=1);

namespace App\DTO\Transformer;

use App\DTO\ResponseDTOInterface;
use App\Factory\ResponseDTO\ResponseDTOFactoryInterface;

final class ResponseDTOTransformer extends AbstractResponseDTOTransformer
{
    /** @var ResponseDTOFactoryInterface[] */
    private array $responseDTOFactories = [];

    /** @param ResponseDTOFactoryInterface[] $iterator */
    public function __construct(iterable $iterator)
    {
        foreach ($iterator as $item) {
            $this->responseDTOFactories[] = $item;
        }
    }

    public function transformFromObject(mixed $object): ResponseDTOInterface
    {
        foreach ($this->responseDTOFactories as $factory) {
            if ($factory->supports($object)) {
                return $factory->create($object);
            }
        }

        throw new \Exception(sprintf('Response DTO factory for %s not implemented', $object::class), 500);
    }
}
