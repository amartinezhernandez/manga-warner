<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messaging\Transformer;

use RuntimeException;
use App\Shared\Domain\Event\DomainEvent;

use function Lambdish\Phunctional\get;

final class ArrayToDomainEventTransformer implements ArrayToMessageTransformer
{
    /** @param iterable<string, string> $mappings */
    public function __construct(private readonly iterable $mappings = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function toMessage(array $payload): DomainEvent
    {
        $messageName = $payload['data']['message_name'];

        /** @var DomainEvent|null $eventClass */
        $eventClass = get($messageName, $this->mappings);

        if (null === $eventClass) {
            throw new RuntimeException("The event <$messageName> doesn't exist or has no subscribers");
        }

        /** @var array<string, string> $body */
        $body = $payload['data']['payload'];
        $aggregateId = $body['aggregate_id'];

        return $eventClass::fromPrimitives(
            $aggregateId,
            $body,
            $payload['data']['message_id'],
            $payload['data']['message_version'],
            $payload['data']['occurred_on_in_atom'],
        );
    }
}
