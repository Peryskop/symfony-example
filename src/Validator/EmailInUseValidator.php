<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class EmailInUseValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (! $constraint instanceof EmailInUse) {
            throw new UnexpectedTypeException($constraint, EmailInUse::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if ($this->userRepository->checkIfEmailExists($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
