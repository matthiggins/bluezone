<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Common;

final class MatchDefinition extends TelemetryEvent
{
    public string $type = 'match definition';

    public function __construct(
        public readonly string $matchId,
        public readonly ?string $pingQuality,
        public readonly ?string $seasonState,
        public readonly Common $common,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            matchId: $data['MatchId'],
            pingQuality: $data['PingQuality'] ?? null,
            seasonState: $data['SeasonState'] ?? null,
            common: Common::make(['isGame' => 0]),
        );
    }
}
