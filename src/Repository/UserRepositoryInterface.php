<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AppUserInterface;
use Doctrine\Persistence\ObjectRepository;

interface UserRepositoryInterface extends ObjectRepository
{
    public function save(AppUserInterface $user): void;

    public function flush(): void;

    public function checkIfEmailExists(string $email): bool;
}
