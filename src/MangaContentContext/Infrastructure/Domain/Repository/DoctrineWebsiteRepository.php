<?php

declare(strict_types=1);

namespace App\MangaContentContext\Infrastructure\Domain\Repository;

use App\MangaContentContext\Domain\Aggregate\Website;
use App\Shared\Infrastructure\Domain\Repository\DoctrineRepository;

final class DoctrineWebsiteRepository extends DoctrineRepository
{
    /** @return Website[] */
    public function all(): array
    {
        return $this->repository()->findAll();
    }

    protected function entityClass(): string
    {
        return Website::class;
    }
}