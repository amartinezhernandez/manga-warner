<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\Order;

use Assert\Assertion;
use Assert\AssertionFailedException;

final class Order
{
    private function __construct(private readonly OrderBy $orderBy, private readonly OrderType $orderType)
    {
    }

    /** @throws AssertionFailedException */
    public static function fromValuesOrNull(?string $orderBy, ?string $order): ?self
    {
        if (null === $orderBy) {
            return null;
        }

        return new self(
            OrderBy::from($orderBy),
            self::orderTypeFrom($order),
        );
    }

    public function orderBy(): OrderBy
    {
        return $this->orderBy;
    }

    public function orderType(): OrderType
    {
        return $this->orderType;
    }

    /** @throws AssertionFailedException */
    private static function orderTypeFrom(?string $order): OrderType
    {
        if (null !== $order) {
            $order = strtolower($order);
            Assertion::choice($order, [OrderType::DESC->value, OrderType::ASC->value]);
        }

        return OrderType::from($order ?? OrderType::DESC->value);
    }
}
