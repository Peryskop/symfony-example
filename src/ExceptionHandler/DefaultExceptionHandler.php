<?php

declare(strict_types=1);

namespace App\ExceptionHandler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class DefaultExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(ExceptionEvent $event): void
    {
        if ($_ENV['PRETTY_EXCEPTIONS'] === 'false') {
            return;
        }

        $exception = $event->getThrowable();
        $message['message'] = $exception->getMessage();
        $code = $exception->getPrevious()?->getCode();

        if (! $code || $code < 400) {
            $code = $exception->getCode() !== 0 ? $exception->getCode() : 500;
        }

        if ($code >= 500) {
            $message['message'] = 'Something went wrong';
        }

        $customResponse = new JsonResponse(data: $message, status: (int) $code);

        $event->setResponse($customResponse);
    }

    public function supports(\Throwable $throwable): bool
    {
        return true;
    }

    public function getPriority(): int
    {
        return 100;
    }
}
