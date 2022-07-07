<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

abstract class PaginatorQueryResponse implements \JsonSerializable, QueryResponse
{
    /**
     * @param array<int, object> $results
     * @param int $page
     * @param int $limit
     * @param int $numResults
     */
    final protected function __construct(
        private readonly array $results,
        private readonly int $page,
        private readonly int $limit,
        private readonly int $numResults,
    ) {
    }

    /** @return array<object> */
    public function results(): array
    {
        return $this->results;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function numResults(): int
    {
        return $this->numResults;
    }

    /** @param array<int, object> $results */
    public static function write(array $results, int $page, int $limit, int $numResults): static
    {
        return new static(array_values($results), $page, $limit, $numResults);
    }

    /** @return array{results: array<object>,meta: array{current_page: int, last_page: int, size: int, total: int}} */
    public function jsonSerialize(): array
    {
        return [
            'results' => $this->results(),
            'meta' => [
                'current_page' => $this->page(),
                'last_page' => $this->numPages(),
                'size' => $this->limit(),
                'total' => $this->numResults(),
            ],
        ];
    }

    private function numPages(): int
    {
        return (int) ceil($this->numResults() / $this->limit());
    }
}
