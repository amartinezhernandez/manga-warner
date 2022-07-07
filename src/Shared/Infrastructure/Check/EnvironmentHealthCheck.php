<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Check;

use Symfony\Component\DependencyInjection\ContainerInterface;

final class EnvironmentHealthCheck implements HealthCheck
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function name(): string
    {
        return 'environment';
    }

    public function status(): string
    {
        return $this->container->getParameter('kernel.environment');
    }
}
