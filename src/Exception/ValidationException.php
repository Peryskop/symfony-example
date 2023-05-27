<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

final class ValidationException extends \Exception
{
    /** @param mixed[] $errors */
    public function __construct(array $errors, int $code = Response::HTTP_UNPROCESSABLE_ENTITY, ?\Throwable $previous = null)
    {
        parent::__construct(json_encode($errors, JSON_THROW_ON_ERROR), $code, $previous);
    }

    public function getDecodedMessage(): mixed
    {
        return json_decode($this->getMessage(), true);
    }
}
