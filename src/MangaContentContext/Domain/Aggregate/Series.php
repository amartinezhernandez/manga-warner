<?php

declare(strict_types=1);

namespace App\MangaContentContext\Domain\Aggregate;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;

final class Series extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $id,
        private readonly string $name,
        private readonly string $slug,
        private readonly string $image,
    ) {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function __toString(): string
    {
        return $this->id()->id();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->id(),
        ];
    }
}