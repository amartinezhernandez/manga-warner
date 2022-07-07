<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

// phpcs:ignore SlevomatCodingStandard.Classes.RequireAbstractOrFinal.ClassNeitherAbstractNorFinal
class PercentageValueObject implements ValueObject
{
    private float $value;

    /** @throws AssertionFailedException */
    protected function __construct(float $value)
    {
        $this->setValue($value);
    }

    /** @throws AssertionFailedException */
    public static function from(float $value): self
    {
        return new self($value);
    }

    /** @throws AssertionFailedException */
    public static function fromOrNull(?float $value = null): ?self
    {
        return null === $value ? null : new self($value);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function isEqualTo(object $other): bool
    {
        return $this instanceof $other && method_exists($other, 'value') && $this->value() === $other->value();
    }

    public function jsonSerialize(): float
    {
        return $this->value;
    }

    /** @throws AssertionFailedException */
    private function setValue(float $value): void
    {
        $this->ensureItIsValid($value);
        $this->value = $value;
    }

    /** @throws AssertionFailedException */
    private function ensureItIsValid(float $value): void
    {
        Assertion::betweenExclusive($value, 0, 100);
    }
}
