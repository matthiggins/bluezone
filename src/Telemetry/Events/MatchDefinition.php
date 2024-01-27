<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;

class MatchDefinition extends TelemetryEvent
{
    public string $type = 'match definition';

    public function __construct(
        readonly public string $matchId,
        readonly public string|null $pingQuality,
        readonly public string|null $seasonState,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            matchId: $data['MatchId'],
            pingQuality: $data['PingQuality'] ?? null,
            seasonState: $data['SeasonState'] ?? null,
            common: Common::make(['isGame' => 0]),
        );
    }
}
