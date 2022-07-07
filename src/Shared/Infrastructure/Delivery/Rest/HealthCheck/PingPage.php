<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Delivery\Rest\HealthCheck;

use Symfony\Component\HttpFoundation\JsonResponse;

final class PingPage
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            'pong',
        );
    }
}
