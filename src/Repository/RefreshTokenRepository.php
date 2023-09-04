<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RefreshToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;

final class RefreshTokenRepository extends ServiceEntityRepository
{
    public function __construct(readonly ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    public function save(RefreshTokenInterface $refreshToken): void
    {
        $this->_em->persist($refreshToken);
        $this->flush();
    }

    public function remove(RefreshToken $refreshToken, bool $flush = true): void
    {
        $this->_em->remove($refreshToken);

        if ($flush) {
            $this->flush();
        }
    }

    public function flush(): void
    {
        $this->_em->flush();
    }
}
