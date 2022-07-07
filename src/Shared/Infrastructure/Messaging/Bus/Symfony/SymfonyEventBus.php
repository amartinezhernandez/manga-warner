<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messaging\Bus\Symfony;

use Symfony\Component\Messenger\MessageBusInterface;
use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Infrastructure\Messaging\Bus\EventBus;

use function Lambdish\Phunctional\each;

final class SymfonyEventBus implements EventBus
{
    public function __construct(private readonly MessageBusInterface $eventBus)
    {
    }

    public function publish(DomainEvent ...$domainEvents): void
    {
        each($this->publisher(), $domainEvents);
    }

    private function publisher(): \Closure
    {
        return fn (DomainEvent $domainEvent) => $this->eventBus->dispatch($domainEvent);
    }
}
