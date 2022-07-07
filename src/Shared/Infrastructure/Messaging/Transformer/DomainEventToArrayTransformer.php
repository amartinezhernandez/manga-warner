<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messaging\Transformer;

use Carbon\CarbonImmutable;
use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Infrastructure\Messaging\Formatter\AsyncApiFormatter;

final class DomainEventToArrayTransformer implements MessageToArrayTransformer
{
    /**
     * {@inheritDoc}
     */
    public function toArray(DomainEvent $domainEvent): array
    {
        return
            [
                'data' => [
                    'message_id' => $domainEvent->messageId(),
                    'message_name' => AsyncApiFormatter::format($domainEvent),
                    'message_version' => $domainEvent->messageVersion(),
                    'payload' => array_merge(
                        $domainEvent->toPrimitives(),
                        ['aggregate_id' => $domainEvent->messageAggregateId()],
                    ),
                    'occurred_on_in_atom' => $domainEvent->occurredOn(),
                    'occurred_on_in_ms' => CarbonImmutable::parse($domainEvent->occurredOn())->getTimestampMs(),
                ],
                'meta' => [],
            ];
    }
}
