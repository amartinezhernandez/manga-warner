<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Delivery\Rest\HealthCheck;

use Carbon\CarbonImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shared\Infrastructure\Check\HealthCheck;

final class HealthCheckGetPage
{
    /** @param array<HealthCheck> $healthChecks */
    public function __construct(private readonly array $healthChecks)
    {
    }

    public function __invoke(): JsonResponse
    {
        $resultHealthCheck = [
            'updated_at' => CarbonImmutable::now()->toIso8601ZuluString(),
            'time_zone' => date_default_timezone_get(),
        ];

        foreach ($this->healthChecks as $healthCheck) {
            $resultHealthCheck[$healthCheck->name()] = $healthCheck->status();
        }

        return new JsonResponse(
            $resultHealthCheck,
        );
    }
}
