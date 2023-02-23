<?php

declare(strict_types=1);

namespace App\MangaContentContext\Domain\Repository;

use App\MangaContentContext\Domain\Aggregate\Subscription;
use App\Shared\Domain\ValueObject\Uuid;

interface SubscriptionRepository
{
    /** @return array<Subscription> */
    public function allBySeriesId(Uuid $seriesId): array;
}