<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

// phpcs:ignore SlevomatCodingStandard.Classes.RequireAbstractOrFinal.ClassNeitherAbstractNorFinal
class RangeIntegerValueObject implements ValueObject
{
    private int $value;

    /** @throws AssertionFailedException */
    protected function __construct(int $value, int $minValue, int $maxValue)
    {
        $this->setValue($value, $minValue, $maxValue);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isEqualTo(object $other): bool
    {
        return $other instanceof self && $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }

    /** @throws AssertionFailedException */
    private function setValue(int $value, int $minValue, int $maxValue): void
    {
        $this->ensureItIsValid($value, $minValue, $maxValue);
        $this->value = $value;
    }

    /** @throws AssertionFailedException */
    private function ensureItIsValid(int $value, int $minValue, int $maxValue): void
    {
        Assertion::betweenExclusive($value, $minValue, $maxValue);
    }
}
