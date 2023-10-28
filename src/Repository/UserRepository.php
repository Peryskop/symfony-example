<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityInterface;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(readonly ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(EntityInterface $user): void
    {
        $this->_em->persist($user);
        $this->flush();
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function delete(User $user): void
    {
        $this->_em->remove($user);
        $this->flush();
    }

    public function checkIfEmailExists(string $email): bool
    {
        $connection = $this->_em->getConnection();
        $statement = $connection->prepare('
            SELECT
                CASE WHEN EXISTS 
                (
                    SELECT * FROM user WHERE email = :email
                )
                THEN TRUE
                ELSE FALSE
            END
            ');

        $statement->bindValue('email', $email);

        return (bool) $statement->executeQuery()->fetchOne();
    }
}
