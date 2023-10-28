<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RefreshToken;
use Doctrine\Persistence\ObjectRepository;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;

interface RefreshTokenRepositoryInterface extends ObjectRepository
{
    public function save(RefreshTokenInterface $refreshToken): void;

    public function remove(RefreshToken $refreshToken, bool $flush = true): void;

    public function flush(): void;
}
