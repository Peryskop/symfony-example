<?php

declare(strict_types=1);

namespace App\Remover;

use App\Entity\RefreshToken;
use App\Repository\RefreshTokenRepositoryInterface;

final readonly class RefreshTokenRemover implements RefreshTokenRemoverInterface
{
    public function __construct(
        private RefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
    }

    public function removeAllUserTokens(string $email, bool $exceptLast = false): void
    {
        $tokens = $this->refreshTokenRepository->findBy([
            'username' => $email,
        ], [
            'id' => 'DESC',
        ]);

        if (! empty($tokens)) {
            /** @var RefreshToken $token */
            foreach ($tokens as $token) {
                if ($exceptLast) {
                    $exceptLast = false;
                    continue;
                }

                $this->refreshTokenRepository->remove($token, false);
            }
        }

        $this->refreshTokenRepository->flush();
    }
}
