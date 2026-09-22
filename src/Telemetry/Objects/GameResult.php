<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class GameResult
{
    public function __construct(
        public readonly int $rank,
        public readonly string $gameResult,
        public readonly int $teamId,
        public readonly Stats $stats,
        public readonly string $accountId,
    ) {}

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
