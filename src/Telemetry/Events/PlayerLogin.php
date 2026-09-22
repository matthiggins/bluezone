<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;

final class PlayerLogin extends TelemetryEvent
{
    public string $type = 'player login';

    public function __construct(
        public readonly string $accountId,
        public readonly Common $common,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            accountId: $data['accountId'],
            common: Common::make($data['common']),
        );
    }
}
