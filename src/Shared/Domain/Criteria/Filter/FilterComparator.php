<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria\Filter;

// phpcs:ignoreFile
enum FilterComparator: string
{
    case EQUAL = '=';
    case CONTAINS = 'like';
    case NOT_EQUAL = '!=';
}
