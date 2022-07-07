<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\Filter;

final class Filter
{
    private function __construct(
        private readonly FilterBy $by,
        private readonly FilterComparator $comparator,
        private readonly FilterValue $value,
    ) {
    }

    public static function from(FilterBy $by, FilterComparator $comparator, FilterValue $value): self
    {
        return new self(
            by: $by,
            comparator: $comparator,
            value : $value,
        );
    }

    public function by(): FilterBy
    {
        return $this->by;
    }

    public function comparator(): FilterComparator
    {
        return $this->comparator;
    }

    public function value(): FilterValue
    {
        return $this->value;
    }
}
