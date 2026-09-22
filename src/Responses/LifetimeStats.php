<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Responses\Concerns\HasGameModeMatches;
use Saloon\Http\Response;

final class LifetimeStats extends PubgResponse
{
    use HasGameModeMatches;

    /**
     * @param  array<string, GameModeStats>  $gameModeStats
     * @param  array<string, array<int, string>>  $matches
     */
    public function __construct(
        public readonly string $accountId,
        public readonly array $gameModeStats,
        public readonly array $matches,
        public readonly float $bestRankPoint,
    ) {}

    public static function make(Response $response): self
    {
        return self::fromArray($response->json('data'));
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            accountId: $data['relationships']['player']['data']['id'],
            gameModeStats: self::statsByMode($data['attributes']['gameModeStats'] ?? []),
            matches: self::matchesByMode($data['relationships']),
            bestRankPoint: (float) ($data['attributes']['bestRankPoint'] ?? 0),
        );
    }
}
