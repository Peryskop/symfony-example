<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Post\PostDTO;
use App\DTO\User\UserDTO;
use App\Factory\DTOFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class RequestToDTOMapper implements EventSubscriberInterface
{
    public function __construct(
        private DTOFactory $DTOFactory
    ) {
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
            $payload = match (true) {
                $argument instanceof PostDTO => $this->DTOFactory->createPostDTOFromRequest($request),
                $argument instanceof UserDTO => $this->DTOFactory->createUserDTOFromRequest($request),
                default => null
            };

            if (! $payload) {
                continue;
            }

            $arguments[$i] = $payload;

            $event->setArguments($arguments);
        }
    }
}
