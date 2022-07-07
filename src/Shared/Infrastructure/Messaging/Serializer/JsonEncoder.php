<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messaging\Serializer;

use RuntimeException;
use Throwable;

final class JsonEncoder
{
    /** @param array<string, mixed> $data */
    public function encode(array $data): string
    {
        try {
            return json_encode(
                $data,
                \JSON_THROW_ON_ERROR | \JSON_FORCE_OBJECT,
            );
        } catch (\Throwable $previous) {
            throw new RuntimeException(
                'Failed to encode data to JSON: '.var_export($data, true),
                0,
                $previous,
            );
        }
    }

    public function decode(string $data): mixed
    {
        try {
            return json_decode(
                $data,
                true,
                512,
                \JSON_THROW_ON_ERROR | \JSON_OBJECT_AS_ARRAY,
            );
        } catch (Throwable $previous) {
            throw new RuntimeException(
                'Failed to decode data into JSON: '.$data,
                0,
                $previous,
            );
        }
    }
}
