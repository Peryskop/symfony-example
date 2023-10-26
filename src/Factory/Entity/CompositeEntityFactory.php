<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\DTO\DTOInterface;
use App\Entity\EntityInterface;

final class CompositeEntityFactory implements CompositeEntityFactoryInterface
{
    /** @var EntityFactoryInterface[] */
    private array $entityFactoryInterfaces = [];

    /** @param EntityFactoryInterface[] $iterator */
    public function __construct(iterable $iterator)
    {
        foreach ($iterator as $item) {
            $this->entityFactoryInterfaces[] = $item;
        }
    }

    public function create(DTOInterface $DTO): EntityInterface
    {
        foreach ($this->entityFactoryInterfaces as $factory) {
            if ($factory->supports($DTO)) {
                return $factory->create($DTO);
            }
        }

        throw new \Exception(sprintf('Factory to create entity from %s not implemented', $DTO::class));
    }
}
