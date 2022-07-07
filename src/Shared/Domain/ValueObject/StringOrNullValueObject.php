<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

// phpcs:ignore SlevomatCodingStandard.Classes.RequireAbstractOrFinal.ClassNeitherAbstractNorFinal
class StringOrNullValueObject implements ValueObject
{
    private ?string $value;

    /** @throws AssertionFailedException */
    final private function __construct(?string $value)
    {
        $this->setValue($value);
    }

    /** @throws AssertionFailedException */
    public static function from(?string $value): static
    {
        return new static($value);
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function jsonSerialize(): string|null
    {
        return $this->value;
    }

    public function isEqualTo(object $other): bool
    {
        return $this instanceof $other && method_exists($other, 'value') && $this->value() === $other->value();
    }

    /** @throws AssertionFailedException */
    private function setValue(?string $value): void
    {
        if (\is_string($value)) {
            Assertion::notBlank($value);
            $value = trim($value);
        }

        $this->value = $value;
    }
}
