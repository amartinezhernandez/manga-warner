<?php

declare(strict_types=1);

namespace App\MangaContentContext\Domain\Repository;

use App\MangaContentContext\Domain\Aggregate\Series;
use App\Shared\Domain\ValueObject\Uuid;

interface SeriesRepository
{
    public function ofId(Uuid $uuid): ?Series;
}