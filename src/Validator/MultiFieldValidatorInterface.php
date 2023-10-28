<?php

declare(strict_types=1);

namespace App\Validator;

interface MultiFieldValidatorInterface
{
    /** @param string[] $groups */
    public function validate(mixed $value, array $groups): void;
}
