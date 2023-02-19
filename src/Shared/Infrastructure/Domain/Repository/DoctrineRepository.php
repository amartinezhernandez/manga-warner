<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Domain\Repository;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/** @template T of AggregateRoot */
abstract class DoctrineRepository
{
    final public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @phpstan-return T|null
     * @return T|null
     */
    public function ofId(Uuid $uuid): ?AggregateRoot
    {
        return $this->repository()->find((string) $uuid);
    }

    /** @return ObjectRepository<T> */
    protected function repository(): ObjectRepository
    {
        /* @phpstan-ignore-next-line */
        return $this->entityManager->getRepository($this->entityClass());
    }

    /** @phpstan-return class-string<object> */
    abstract protected function entityClass(): string;
}
