<?php

declare(strict_types=1);

namespace App\MangaContentContext\Infrastructure\Domain\Repository;

use App\MangaContentContext\Domain\Aggregate\Subscription;
use App\MangaContentContext\Domain\Repository\SubscriptionRepository;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Domain\Repository\DoctrineRepository;

final class DoctrineSubscriptionRepository extends DoctrineRepository implements SubscriptionRepository
{
    public function allBySeriesId(Uuid $seriesId): array
    {
        return $this->repository()->findBy([
            'seriesId' => $seriesId,
        ]);
    }

    protected function entityClass(): string
    {
        return Subscription::class;
    }
}