<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messaging\Bus;

use App\Shared\Domain\Event\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$domainEvents): void;
}
