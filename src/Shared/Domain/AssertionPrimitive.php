<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use Assert\Assertion;
use Closure;

use function Lambdish\Phunctional\each;

final class AssertionPrimitive
{
    /** @phpstan-ignore-next-line */
    public static function primitives(iterable $payload): void
    {
        each(self::ensureThatValueIsPrimitive(), $payload);
    }

    private static function ensureThatValueIsPrimitive(): Closure
    {
        return static function (mixed $value): void {
            Assertion::false(\is_object($value), 'Payload parameters only can be primitive.');

            if (!\is_array($value)) {
                return;
            }

            self::primitives($value);
        };
    }
}
