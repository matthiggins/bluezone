<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Requests\TelemetryRequest;
use Bluezone\Responses\PubgResponse;

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
