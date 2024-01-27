<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Concerns;

use Bluezone\Exceptions\ItemNotFoundException;

trait AccessesJsonDictionaries
{
    /**
     * Get json file from path
     */
    public function getJsonFromFile(string $path): array
    {
        $json = file_get_contents(__DIR__.'/../../assets/dictionaries/'.$path);

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
        
        // if( ! $json[$key]) {
        //     throw new ItemNotFoundException("Item could not be found in {$path}", $key);
        // }

        return $json[$key] ?? $key;
    }
}
