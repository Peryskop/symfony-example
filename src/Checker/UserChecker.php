<?php

declare(strict_types=1);

namespace App\Checker;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserChecker
{
    public static function check(UserInterface $user): User
    {
        if (! $user instanceof User) {
            throw new \Exception('Invalid user exception');
        }

        return $user;
    }
}
