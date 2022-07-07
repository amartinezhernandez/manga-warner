<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;

use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\VarDateTimeImmutableType;

final class DateTimeInMicrosecondsType extends VarDateTimeImmutableType
{
    private const FIELD_ID = 'datetime_in_microseconds';

    public function getName(): string
    {
        return self::FIELD_ID;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'TIMESTAMP(3) WITHOUT TIME ZONE';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof DateTimeInterface && ($platform instanceof PostgreSQLPlatform)) {
            $dateTimeFormat = $platform->getDateTimeFormatString();

            return $value->format("{$dateTimeFormat}.u");
        }

        return parent::convertToDatabaseValue($value, $platform);
    }
}
