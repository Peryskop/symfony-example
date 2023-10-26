<?php

declare(strict_types=1);

namespace App\Updater\Entity;

use App\DTO\DTOInterface;
use App\Entity\EntityInterface;

final class CompositeEntityUpdater implements CompositeEntityUpdaterInterface
{
    /** @var EntityUpdaterInterface[] */
    private array $entityUpdaters = [];

    /** @param EntityUpdaterInterface[] $iterator */
    public function __construct(iterable $iterator)
    {
        foreach ($iterator as $item) {
            $this->entityUpdaters[] = $item;
        }
    }

    public function update(EntityInterface $entity, DTOInterface $DTO): void
    {
        foreach ($this->entityUpdaters as $updater) {
            if ($updater->supports($entity)) {
                $updater->update($entity, $DTO);
                return;
            }
        }

        throw new \Exception(sprintf('Updater for %s not implemented', $entity::class));
    }
}
