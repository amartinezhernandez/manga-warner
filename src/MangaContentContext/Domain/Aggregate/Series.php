<?php

declare(strict_types=1);

namespace App\MangaContentContext\Domain\Aggregate;

use App\Shared\Domain\ValueObject\Uuid;

final class Series
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
}