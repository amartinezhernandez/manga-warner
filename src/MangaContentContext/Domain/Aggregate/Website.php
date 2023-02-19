<?php

declare(strict_types=1);

namespace App\MangaContentContext\Domain\Aggregate;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;

final class Website extends AggregateRoot
{public function __construct(
        private Uuid $id,
        private string $name,
        private ?string $feedUrl
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

    public function feedUrl(): ?string
    {
        return $this->feedUrl;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'feed_url' => $this->feedUrl,
        ];
    }
}