<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Factory\DTO\DTOFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class RequestToDTOMapper implements EventSubscriberInterface
{
    /** @var DTOFactoryInterface[] */
    private array $DTOFactories = [];

    /** @param DTOFactoryInterface[] $iterator */
    public function __construct(iterable $iterator)
    {
        foreach ($iterator as $item) {
            $this->DTOFactories[] = $item;
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => 'onKernelControllerArguments',
        ];
    }

    public function onKernelControllerArguments(ControllerArgumentsEvent $event): void
    {
        $arguments = $event->getArguments();
        $request = $event->getRequest();

        foreach ($arguments as $i => $argument) {
            $payload = null;

            foreach ($this->DTOFactories as $factory) {
                if ($factory->supports($argument)) {
                    $payload = $factory->create($request);
                    break;
                }
            }

            if (! $payload) {
                continue;
            }

            $arguments[$i] = $payload;

            $event->setArguments($arguments);
        }
    }
}
