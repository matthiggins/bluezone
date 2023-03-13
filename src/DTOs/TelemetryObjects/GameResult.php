<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryObjects;

class GameResult
{
    public function __construct(
        readonly public int $rank,
        readonly public string $gameResult,
        readonly public int $teamId,
        readonly public Stats $stats,
        readonly public string $accountId,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            rank: $data['rank'],
            gameResult: $data['gameResult'],
            teamId: $data['teamId'],
            stats: Stats::fromEvent($data['stats']),
            accountId: $data['accountId'],
        );
    }
}
