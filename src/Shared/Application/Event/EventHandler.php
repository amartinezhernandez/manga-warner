<?php

declare(strict_types=1);

namespace App\Shared\Application\Event;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Shared\Infrastructure\Generator\UuidGenerator;

abstract class EventHandler implements MessageHandlerInterface
{
    public function __construct(
        protected readonly MessageBusInterface $commandBus,
        protected readonly UuidGenerator $uuidGenerator,
    ) {
    }
}
