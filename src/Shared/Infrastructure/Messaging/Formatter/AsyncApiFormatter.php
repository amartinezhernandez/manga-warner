<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messaging\Formatter;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Stringable;
use Throwable;
use App\Shared\Domain\Event\DomainEvent;

final class AsyncApiFormatter implements Stringable
{
    private const ORGANIZATION_NAME = 'whalar';

    /** @TODO Project name */
    private const APPLICATION_NAME = 'global';
    private const MESSAGE_TYPE = 'domain_event';

    private string $organization;
    private string $application;
    private int $messageVersion;
    private string $messageType;
    private string $aggregateName;
    private string $aggregationAction;

    /** @throws AssertionFailedException */
    private function __construct(
        string $organization,
        string $application,
        int $messageVersion,
        string $messageType,
        string $aggregateName,
        string $aggregateAction,
    ) {
        $this->setOrganization($organization)
            ->setApplication($application)
            ->setMessageVersion($messageVersion)
            ->setMessageType($messageType)
            ->setAggregateName($aggregateName)
            ->setAggregateAction($aggregateAction);
    }

    /** @throws AssertionFailedException */
    public static function from(
        string $organization,
        string $application,
        int $messageVersion,
        string $messageType,
        string $aggregateName,
        string $aggregateAction,
    ): self {
        return new self($organization, $application, $messageVersion, $messageType, $aggregateName, $aggregateAction);
    }

    /** @throws AssertionFailedException */
    public static function fromAsyncApiFormat(string $asyncApiFormat): self
    {
        [$organization, $application, $messageVersion, $messageType, $aggregateName, $aggregateAction] = explode(
            '.',
            $asyncApiFormat,
        );

        return new self(
            $organization,
            $application,
            (int) $messageVersion,
            $messageType,
            $aggregateName,
            $aggregateAction,
        );
    }

    /**
     * @throws Throwable
     * @throws AssertionFailedException
     */
    public static function format(DomainEvent $domainEvent): string
    {
        return self::from(
            self::ORGANIZATION_NAME,
            self::APPLICATION_NAME,
            $domainEvent->messageVersion(),
            self::MESSAGE_TYPE,
            $domainEvent->messageAggregateName(),
            $domainEvent->messageAggregateAction(),
        )->__toString();
    }

    public function organization(): string
    {
        return $this->organization;
    }

    public function application(): string
    {
        return $this->application;
    }

    public function messageVersion(): int
    {
        return $this->messageVersion;
    }

    public function messageType(): string
    {
        return $this->messageType;
    }

    public function aggregateName(): string
    {
        return $this->aggregateName;
    }

    public function aggregationAction(): string
    {
        return $this->aggregationAction;
    }

    public function toAsyncApiFormat(): string
    {
        return sprintf(
            '%s.%s.%s.%s.%s.%s',
            $this->organization(),
            $this->application(),
            $this->messageVersion(),
            $this->messageType(),
            $this->aggregateName(),
            $this->aggregationAction(),
        );
    }

    public function __toString(): string
    {
        return $this->toAsyncApiFormat();
    }

    /** @throws AssertionFailedException */
    private function setOrganization(string $organization): self
    {
        Assertion::notBlank($organization);
        $this->organization = trim($organization);

        return $this;
    }

    /** @throws AssertionFailedException */
    private function setApplication(string $application): self
    {
        Assertion::notBlank($application);
        $this->application = trim($application);

        return $this;
    }

    /** @throws AssertionFailedException */
    private function setMessageVersion(int $messageVersion): self
    {
        Assertion::greaterThan($messageVersion, 0);
        $this->messageVersion = $messageVersion;

        return $this;
    }

    /** @throws AssertionFailedException */
    private function setMessageType(string $type): self
    {
        Assertion::choice($type, ['command', 'domain_event', 'query']);
        $this->messageType = $type;

        return $this;
    }

    /** @throws AssertionFailedException */
    private function setAggregateName(string $aggregateName): self
    {
        Assertion::notBlank($aggregateName);
        $this->aggregateName = trim($aggregateName);

        return $this;
    }

    /** @throws AssertionFailedException */
    private function setAggregateAction(string $aggregationAction): void
    {
        Assertion::notBlank($aggregationAction);
        $this->aggregationAction = trim($aggregationAction);
    }
}
