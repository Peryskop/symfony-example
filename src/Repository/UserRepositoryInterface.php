<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityInterface;
use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(EntityInterface $user): void;

    public function flush(): void;

    public function delete(User $user): void;

    public function checkIfEmailExists(string $email): bool;
}
