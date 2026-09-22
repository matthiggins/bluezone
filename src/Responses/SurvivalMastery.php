<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Http\Response;

final class SurvivalMastery extends PubgResponse
{
    /** @param array<string, SurvivalStat> $stats */
    public function __construct(
        public readonly string $accountId,
        public readonly int $xp,
        public readonly int $level,
        public readonly int $tier,
        public readonly string $lastMatchId,
        public readonly int $totalMatchesPlayed,
        public readonly array $stats,
    ) {}

    public static function make(Response $response): self
    {
        $data = $response->json('data');
        $stats = $data['attributes']['stats'] ?? [];

        return new self(
            accountId: $data['id'],
            xp: (int) ($data['attributes']['xp'] ?? 0),
            level: (int) ($data['attributes']['level'] ?? 0),
            tier: (int) ($data['attributes']['tier'] ?? 0),
            lastMatchId: (string) ($data['attributes']['lastMatchId'] ?? ''),
            totalMatchesPlayed: (int) ($data['attributes']['totalMatchesPlayed'] ?? 0),
            stats: array_combine(
                array_keys($stats),
                array_map(SurvivalStat::fromArray(...), array_keys($stats), $stats),
            ),
        );
    }
}
