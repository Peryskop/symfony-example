<?php

declare(strict_types=1);

namespace App\Remover;

interface RefreshTokenRemoverInterface
{
    public function removeAllUserTokens(string $email, bool $exceptLast = false): void;
}
