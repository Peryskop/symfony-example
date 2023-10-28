<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\DTO\DTOInterface;
use App\DTO\User\UserDTO;
use App\DTO\User\UserDTOInterface;
use App\Entity\EntityInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UserFactory implements EntityFactoryInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /** @param UserDTOInterface $DTO */
    public function create(DTOInterface $DTO): EntityInterface
    {
        $user = new User();

        $user->setEmail($DTO->getEmail());

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $DTO->getPassword()
        );
        $user->setPassword($hashedPassword);
        $user->setFirstName($DTO->getFirstName());
        $user->setLastName($DTO->getLastName());

        return $user;
    }

    public function supports(DTOInterface $DTO): bool
    {
        return $DTO::class === UserDTO::class;
    }
}
