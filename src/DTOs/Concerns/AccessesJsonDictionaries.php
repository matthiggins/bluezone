<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\Concerns;

trait AccessesJsonDictionaries
{
    /**
     * Get json file from path
     */
    public function getJsonFromFile(string $path): array
    {
        $json = file_get_contents(storage_path('pubg-assets/dictionaries/'.$path));

        return json_decode($json, true);
    }

    /**
     * Get value from json file
     */
    public function getValueFromJsonFile(string $path, string $key): string
    {
        if (! $key) {
            return '';
        }
        $json = $this->getJsonFromFile($path);

        return $json[$key];
    }
}
