<?php

declare(strict_types=1);

namespace App\MangaContentContext\Domain\Aggregate;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class Chapter
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $seriesId,
        private readonly int $chapter,
        private readonly string $link,
        private readonly DateTimeImmutable $date,
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

    public function chapter(): int
    {
        return $this->chapter;
    }

    public function link(): string
    {
        return $this->link;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }
}