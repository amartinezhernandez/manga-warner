<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Generator;

interface UuidGenerator
{
    public function generate(): string;
}
