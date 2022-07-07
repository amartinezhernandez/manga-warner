<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use ReflectionClass;

final class ClassFunctions
{
    public static function extractClassName(object $object): string
    {
        $reflect = new ReflectionClass($object);

        if ($reflect->isAnonymous()) {
            return '';
        }

        return $reflect->getShortName();
    }

    public static function extractClassNameFromString(string $className): string
    {
        $classNameSplit = explode('\\', $className);

        $nameSanitized = preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', end($classNameSplit));

        return ltrim(strtolower("$nameSanitized"), '_');
    }

    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text)
            ? $text
            : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $text) ?? '');
    }

    public static function toCamelCase(string $text): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $text))));
    }
}
