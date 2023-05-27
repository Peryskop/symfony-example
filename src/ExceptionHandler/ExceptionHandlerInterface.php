<?php

declare(strict_types=1);

namespace App\ExceptionHandler;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

interface ExceptionHandlerInterface
{
    public function handle(ExceptionEvent $event): void;

    public function supports(\Throwable $throwable): bool;

    public function getPriority(): int;
}
