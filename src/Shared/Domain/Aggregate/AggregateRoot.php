<?php

declare(strict_types=1);

namespace App\Shared\Domain\Aggregate;

use JsonSerializable;
use Stringable;
use App\Shared\Domain\Event\DomainEvent;

abstract class AggregateRoot implements JsonSerializable, Stringable
{
    /** @var array<DomainEvent> */
    private array $events = [];

    /** @return array<DomainEvent> */
    final public function events(): array
    {
        return $this->events;
    }

    final public function resetEvents(): void
    {
        $this->events = [];
    }

    final protected function recordThat(DomainEvent $event): void
    {
        $this->events[] = $event;
    }
}
