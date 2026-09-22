<?php

declare(strict_types=1);

namespace Bluezone\Exceptions;

final class InvalidTelemetryUrlException extends BluezoneException
{
    public static function forUrl(string $url): self
    {
        return new self("Telemetry urls must be on telemetry-cdn.pubg.com; got [{$url}].");
    }
}
