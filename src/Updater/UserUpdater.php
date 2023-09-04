<?php

declare(strict_types=1);

namespace App\Updater;

use App\DTO\User\UserDTO;
use App\Entity\User;

final readonly class UserUpdater
{
    public function update(User $user, UserDTO $userDTO): void
    {
        $user->setFirstName($userDTO->firstName);
        $user->setLastName($userDTO->lastName);
    }
}
