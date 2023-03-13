<?php

namespace Bluezone\Resources;

use Bluezone\Requests\Telemetry\TelemetryRequest;
use Saloon\Http\Response;

class TelemetryResource extends Resource
{
    /**
     * Get a telemetry file from a url
     */
    public function find(string $url): Response
    {
        return $this->connector->send(new TelemetryRequest(
            url: $url,
        ));
    }
}
