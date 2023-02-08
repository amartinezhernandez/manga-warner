<?php

declare(strict_types=1);

namespace App\WebhookContext\Domain\Exception;

use App\Shared\Domain\DomainException;
use App\Shared\Domain\Exception\Http\ForbiddenException;

final class WebhookErrorException extends DomainException implements ForbiddenException
{
    public static function empty(): self
    {
        return new self('Error setting the webhook');
    }
}