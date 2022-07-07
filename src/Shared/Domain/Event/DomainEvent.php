<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use Assert\AssertionFailedException;
use Carbon\CarbonImmutable;
use Throwable;
use App\Shared\Domain\ClassFunctions;
use App\Shared\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    protected const MESSAGE_VERSION = 1;

    private string $messageId;
    private int $messageVersion;
    private string $occurredOn;

    /** @throws AssertionFailedException */
    protected function __construct(
        private readonly string $aggregateId,
        ?string $messageId = null,
        ?int $messageVersion = null,
        ?string $occurredOn = null,
    ) {
        $this->messageId = $messageId ?? Uuid::random()->id();
        $this->messageVersion = $messageVersion ?? self::MESSAGE_VERSION;
        // @TODO Value object to common format
        $this->occurredOn = $occurredOn ?? CarbonImmutable::now('utc')->toAtomString();
    }

    /**
     * @param array<string, string> $payload
     * @return static
     */
    abstract public static function fromPrimitives(
        string $aggregateId,
        array $payload,
        string $messageId,
        int $messageVersion,
        string $occurredOn,
    ): self;

    /** @return array<string, mixed> */
    abstract public function toPrimitives(): array;

    public function messageAggregateId(): string
    {
        return $this->aggregateId;
    }

    abstract public function aggregateName(): string;

    public function messageId(): string
    {
        return $this->messageId;
    }

    public function messageAggregateName(): string
    {
        return ClassFunctions::extractClassNameFromString($this->aggregateName());
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }

    public function messageVersion(): int
    {
        return $this->messageVersion;
    }

    public function messageType(): string
    {
        return 'domain_event';
    }

    /** @throws Throwable */
    public function messageAggregateAction(): string
    {
        $value = ClassFunctions::extractClassName($this);

        return ClassFunctions::toSnakeCase($value);
    }
}
