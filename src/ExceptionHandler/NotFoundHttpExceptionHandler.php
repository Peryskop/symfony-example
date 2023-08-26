<?php

declare(strict_types=1);

namespace App\ExceptionHandler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class NotFoundHttpExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(ExceptionEvent $event): void
    {
        $customResponse = new JsonResponse(data: [
            'message' => 'Not found',
        ], status: Response::HTTP_NOT_FOUND);

        $event->setResponse($customResponse);
    }

    public function supports(\Throwable $throwable): bool
    {
        return $throwable::class == NotFoundHttpException::class;
    }

    public function getPriority(): int
    {
        return 0;
    }
}
