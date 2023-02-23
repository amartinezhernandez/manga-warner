<?php

declare(strict_types=1);

namespace App\MangaContentContext\Domain\Aggregate;

use App\Shared\Domain\ValueObject\Uuid;

final class Subscription
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $seriesId,
        private readonly string $chatId,
    ) {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function seriesId(): Uuid
    {
        return $this->seriesId;
    }

    public function chatId(): string
    {
        return $this->chatId;
    }
}