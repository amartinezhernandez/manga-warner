<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Generator;

use Symfony\Component\Uid\Uuid;

final class SymfonyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::v4()->toRfc4122();
    }
}
