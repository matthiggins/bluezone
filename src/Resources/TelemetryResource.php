<?php

namespace Bluezone\Resources;

use Bluezone\Responses\PubgResponse;
use Bluezone\Requests\TelemetryRequest;

class TelemetryResource extends Resource
{
    /**
     * Get a telemetry file from a url
     */
    public function find(string $url): PubgResponse
    {
        return $this->send(new TelemetryRequest(
            url: $url,
        ));
    }
}
