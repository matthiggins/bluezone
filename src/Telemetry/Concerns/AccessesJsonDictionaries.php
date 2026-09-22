<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Concerns;

use Bluezone\Support\Dictionary;

trait AccessesJsonDictionaries
{
    /** @return array<string, mixed> */
    public function getJsonFromFile(string $path): array
    {
        return Dictionary::load($path);
    }

    public function getValueFromJsonFile(string $path, string $key): string
    {
        return Dictionary::get($path, $key);
    }
}
