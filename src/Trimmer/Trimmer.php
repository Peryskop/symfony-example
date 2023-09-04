<?php

declare(strict_types=1);

namespace App\Trimmer;

final class Trimmer
{
    public static function trim(?string $string): ?string
    {
        if ($string === null) {
            return null;
        }

        return trim($string);
    }
}
