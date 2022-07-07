<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Assert\Assertion;

final class Name extends StringValueObject
{
    private const MAX_LENGTH = 64;

    public function name(): string
    {
        return $this->value();
    }

    protected function ensureItIsValid(string $value): void
    {
        parent::ensureItIsValid($value);

        Assertion::maxLength($value, self::MAX_LENGTH);
    }
}
