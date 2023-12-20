<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Common;

class MatchDefinition extends AbstractEventDTO
{
    public string $type = 'match definition';

    public function __construct(
        readonly public string $matchId,
        readonly public string|null $pingQuality,
        readonly public string|null $seasonState,
        readonly public Common $common,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            matchId: $data['MatchId'],
            pingQuality: $data['PingQuality'] ?? null,
            seasonState: $data['SeasonState'] ?? null,
            common: Common::fromEvent(['isGame' => 0]),
        );
    }
}
