<?php

namespace App\Trait;

trait TimestampableTrait
{
    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateTimestamps(): void
    {
        $utcTimeZone = new \DateTimeZone('UTC');

        $this->updatedAt = new \DateTimeImmutable(timezone: $utcTimeZone);
        if (! isset($this->createdAt)) {
            $this->createdAt = new \DateTimeImmutable(timezone: $utcTimeZone);
        }
    }
}
