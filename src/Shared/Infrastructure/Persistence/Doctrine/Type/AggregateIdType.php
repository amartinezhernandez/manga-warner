<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;

use App\Shared\Domain\ValueObject\Uuid;

final class AggregateIdType extends DoctrineEntityIdType
{
    private const FIELD_ID = 'aggregate_id';

    public function getName(): string
    {
        return self::FIELD_ID;
    }

    public function getClassName(): string
    {
        return Uuid::class;
    }
}
