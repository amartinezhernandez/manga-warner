<?php

declare(strict_types=1);

namespace App\MangaContentContext\Application\Command\ChapterFound;

use App\Shared\Application\Command\Command;
use App\Shared\Domain\ValueObject\Uuid;

final class ChapterFoundCommand implements Command
{
    public function __construct(
        private readonly Uuid $seriesId,
        private readonly int $chapter,
        private readonly string $date,
    ) {
    }

    public function seriesId(): Uuid
    {
        return $this->seriesId;
    }

    public function chapter(): int
    {
        return $this->chapter;
    }

    public function date(): string
    {
        return $this->date;
    }
}