<?php

namespace Bluezone\Resources;

use Bluezone\DTOs\PubgDTO;
use Bluezone\Requests\Telemetry\TelemetryRequest;

class TelemetryResource extends Resource
{
    /**
     * Get a telemetry file from a url
     */
    public function find(string $url): PubgDTO
    {
        return $this->send(new TelemetryRequest(
            url: $url,
        ));
    }
}
