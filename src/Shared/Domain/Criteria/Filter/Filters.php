<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\Filter;

/**
 * @phpstan-type RawFilter array{
 *                          filter:string,
 *                          comparator:string,
 *                          value:string,
 * }
 */
final class Filters
{
    /** @var array<Filter> */
    private array $filters;

    private function __construct(Filter ...$filters)
    {
        $this->filters = $filters;
    }

    public static function fromValues(Filter ...$filters): self
    {
        return new self(...$filters);
    }

    public static function empty(): self
    {
        return new self();
    }

    /** @return array<Filter> */
    public function filters(): array
    {
        return $this->filters;
    }

    public function hasFilters(): bool
    {
        return 0 < \count($this->filters);
    }
}
