<?php

declare(strict_types=1);

namespace Bluezone;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;

/** Telemetry files are public CDN downloads of 5-15 MB gzipped, so no auth and a long timeout. */
final class TelemetryConnector extends Connector
{
    use AlwaysThrowOnErrors;
    use HasTimeout;

    protected int $connectTimeout = 10;

    protected int $requestTimeout = 60;

    public function resolveBaseUrl(): string
    {
        return 'https://telemetry-cdn.pubg.com';
    }
}
