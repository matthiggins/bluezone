<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

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

    public static function make(array $data): self
    {
        return new static(
            rank: $data['rank'],
            gameResult: $data['gameResult'],
            teamId: $data['teamId'],
            stats: Stats::make($data['stats']),
            accountId: $data['accountId'],
        );
    }
}
