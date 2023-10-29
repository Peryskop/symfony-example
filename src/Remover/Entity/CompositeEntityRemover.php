<?php

declare(strict_types=1);

namespace App\Remover\Entity;

use App\Entity\EntityInterface;

final class CompositeEntityRemover implements CompositeEntityRemoverInterface
{
    /** @var EntityRemoverInterface[] */
    private array $entityRemovers = [];

    /** @param EntityRemoverInterface[] $iterator */
    public function __construct(iterable $iterator)
    {
        foreach ($iterator as $item) {
            $this->entityRemovers[] = $item;
        }
    }

    public function softDelete(EntityInterface $entity): void
    {
        foreach ($this->entityRemovers as $remover) {
            if ($remover->supports($entity)) {
                $remover->softDelete($entity);
                return;
            }
        }

        throw new \Exception(sprintf('Remover for %s not implemented', $entity::class), 500);
    }

    public function hardDelete(EntityInterface $entity): void
    {
        foreach ($this->entityRemovers as $remover) {
            if ($remover->supports($entity)) {
                $remover->hardDelete($entity);
                return;
            }
        }

        throw new \Exception(sprintf('Remover for %s not implemented', $entity::class), 500);
    }
}
