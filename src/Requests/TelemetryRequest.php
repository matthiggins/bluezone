<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Responses\Telemetry;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\SoloRequest;

class TelemetryRequest extends SoloRequest
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $url,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return $this->url;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Telemetry::make($response);
    }
}
