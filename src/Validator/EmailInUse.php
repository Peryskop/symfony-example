<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

final class EmailInUse extends Constraint
{
    public string $message = 'Email already in use';
}
