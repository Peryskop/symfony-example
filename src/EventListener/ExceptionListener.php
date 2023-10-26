<?php

declare(strict_types=1);

namespace App\EventListener;

use App\ExceptionHandler\ExceptionHandlerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    /** @var ExceptionHandlerInterface[] */
    private array $exceptionsHandlers = [];

    /** @param ExceptionHandlerInterface[] $iterator */
    public function __construct(iterable $iterator)
    {
        foreach ($iterator as $item) {
            $this->exceptionsHandlers[] = $item;
        }

        usort($this->exceptionsHandlers, function ($a, $b) {
            return $a->getPriority() <=> $b->getPriority();
        });
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        foreach ($this->exceptionsHandlers as $handler) {
            if ($handler->supports($event->getThrowable())) {
                $handler->handle($event);
                break;
            }
        }
    }
}
