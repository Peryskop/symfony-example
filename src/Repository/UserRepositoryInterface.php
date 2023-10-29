<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AppUserInterface;

interface UserRepositoryInterface
{
    public function save(AppUserInterface $user): void;

    public function flush(): void;

    public function checkIfEmailExists(string $email): bool;
}
