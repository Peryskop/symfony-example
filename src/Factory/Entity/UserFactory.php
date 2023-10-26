<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\DTO\DTOInterface;
use App\DTO\User\UserDTO;
use App\Entity\EntityInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UserFactory implements EntityFactoryInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /** @param UserDTO $DTO */
    public function create(DTOInterface $DTO): EntityInterface
    {
        $user = new User();

        $user->setEmail($DTO->email);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $DTO->password
        );
        $user->setPassword($hashedPassword);
        $user->setFirstName($DTO->firstName);
        $user->setLastName($DTO->lastName);

        return $user;
    }

    public function supports(DTOInterface $DTO): bool
    {
        return $DTO::class === UserDTO::class;
    }
}
