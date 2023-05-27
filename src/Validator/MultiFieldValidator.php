<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class MultiFieldValidator
{
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @param string[] $groups
     */
    public function validate(mixed $value, array $groups): void
    {
        $violations = $this->validator->validate($value, null, $groups);
        $errors = [];

        if ($violations->count() > 0) {
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }
        }

        if (! empty($errors)) {
            throw new ValidationException($errors);
        }
    }
}
