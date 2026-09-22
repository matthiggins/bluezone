<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Enums\GameMode;
use Saloon\Http\Response;

final class RankedSeasonStats extends PubgResponse
{
    /** @param array<string, RankedGameModeStats> $gameModeStats */
    public function __construct(
        public readonly string $accountId,
        public readonly string $seasonId,
        public readonly array $gameModeStats,
    ) {}

    public static function make(Response $response): self
    {
        return self::fromArray($response->json('data'));
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $modes = $data['attributes']['rankedGameModeStats'] ?? [];

        return new self(
            accountId: $data['relationships']['player']['data']['id'],
            seasonId: $data['relationships']['season']['data']['id'],
            gameModeStats: array_map(RankedGameModeStats::fromArray(...), $modes),
        );
    }

    public function forMode(GameMode|string $mode): ?RankedGameModeStats
    {
        return $this->gameModeStats[GameMode::resolve($mode)->value] ?? null;
    }
}
