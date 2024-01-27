<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;

class PlayerLogout extends TelemetryEvent
{
    public string $type = 'player logout';

    public function __construct(
        readonly public string $accountId,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            accountId: $data['accountId'],
            common: Common::make($data['common']),
        );
    }
}
