<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messaging\Serializer;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;
use Symfony\Component\Messenger\Stamp\RedeliveryStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Throwable;
use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Infrastructure\Messaging\Transformer\ArrayToDomainEventTransformer;
use App\Shared\Infrastructure\Messaging\Transformer\MessageToArrayTransformer;

/** @phpstan-type SerializedMessage array{_meta?:array{retry-count?:int}, data: array{message_id: string,message_name: string,message_version: int,payload: non-empty-array<string,mixed>,occurred_on_in_atom: string,occurred_on_in_ms: int}, meta: array{}} */
final class DomainEventSerializer implements SerializerInterface
{
    public function __construct(
        private readonly MessageToArrayTransformer $toArrayTransformer,
        private readonly ArrayToDomainEventTransformer $toDomainEventTransformer,
        private readonly JsonEncoder $encoder,
    ) {
    }

    /** @phpstan-ignore-next-line */
    public function decode(array $encodedEnvelope): Envelope
    {
        if (!isset($encodedEnvelope['body'])) {
            throw new MessageDecodingFailedException('Encoded envelope should have at least a "body".');
        }

        try {
            /** @var SerializedMessage $array */
            $array = $this->encoder->decode($encodedEnvelope['body']);
        } catch (Throwable $e) {
            throw new MessageDecodingFailedException(
                sprintf('Error when trying to json_decode message: "%s"', $encodedEnvelope['body']),
                0,
                $e,
            );
        }

        $meta = $array['_meta'] ?? [];
        unset($array['_meta']);

        try {
            $message = $this->toDomainEventTransformer->toMessage($array);
            $envelope = new Envelope($message);
        } catch (Throwable $e) {
            throw new MessageDecodingFailedException('Failed to decode message', 0, $e);
        }

        return $this->addMetaToEnvelope($meta, $envelope);
    }

    /**
     * @return array{headers: array{'Content-Type':string}, body: string}
     * @throws Throwable
     */
    public function encode(Envelope $envelope): array
    {
        $envelope = $envelope->withoutStampsOfType(NonSendableStampInterface::class);
        \assert($envelope->getMessage() instanceof DomainEvent);
        $message = $this->toArrayTransformer->toArray($envelope->getMessage());
        $message['meta'] = $this->getMetaFromEnvelope($envelope);

        return [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $this->encoder->encode($message),
        ];
    }

    /** @return array{retry-count?:int} */
    private function getMetaFromEnvelope(Envelope $envelope): array
    {
        $meta = [];

        $redeliveryStamp = $envelope->last(RedeliveryStamp::class);

        if ($redeliveryStamp instanceof RedeliveryStamp) {
            $meta['retry-count'] = $redeliveryStamp->getRetryCount();
        }

        return $meta;
    }

    /** @param array{retry-count?:int} $meta */
    private function addMetaToEnvelope(array $meta, Envelope $envelope): Envelope
    {
        if (isset($meta['retry-count'])) {
            $envelope = $envelope->with(new RedeliveryStamp($meta['retry-count']));
        }

        return $envelope;
    }
}
