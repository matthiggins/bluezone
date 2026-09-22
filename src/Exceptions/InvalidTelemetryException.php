<?php

declare(strict_types=1);

namespace Bluezone\Exceptions;

final class InvalidTelemetryException extends BluezoneException
{
    public static function notDecodable(string $reason): self
    {
        return new self("Telemetry could not be decoded: {$reason}.");
    }
}
