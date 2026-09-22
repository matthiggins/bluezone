<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;

final class PlayerLogout extends TelemetryEvent
{
    public string $type = 'player logout';

    public function __construct(
        public readonly string $accountId,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            accountId: $data['accountId'],
            common: Common::make($data['common']),
        );
    }
}
