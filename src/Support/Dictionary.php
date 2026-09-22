<?php

declare(strict_types=1);

namespace Bluezone\Support;

/** Reads JSON dictionaries synced from pubg/api-assets and caches each file in memory for the process. */
final class Dictionary
{
    /** @var array<string, array<string, mixed>> */
    private static array $files = [];

    /**
     * The translated value for $key in $file, or $key itself when unmapped.
     */
    public static function get(string $file, string $key): string
    {
        if ($key === '') {
            return '';
        }

        $value = self::load($file)[$key] ?? $key;

        return is_string($value) ? $value : $key;
    }

    /** @return array<string, mixed> */
    public static function load(string $file): array
    {
        return self::$files[$file] ??= json_decode(
            (string) file_get_contents(__DIR__.'/../assets/dictionaries/'.$file),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );
    }

    public static function flush(): void
    {
        self::$files = [];
    }
}
