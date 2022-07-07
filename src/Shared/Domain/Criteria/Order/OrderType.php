<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\Order;

// phpcs:ignoreFile
enum OrderType: string
{
    case NONE = 'none';
    case ASC = 'asc';
    case DESC = 'desc';
}
