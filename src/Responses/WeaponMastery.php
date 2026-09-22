<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Saloon\Http\Response;

final class WeaponMastery extends PubgResponse
{
    /** @param array<string, WeaponSummary> $weaponSummaries */
    public function __construct(
        public readonly string $accountId,
        public readonly string $platform,
        public readonly string $seasonId,
        public readonly string $latestMatchId,
        public readonly array $weaponSummaries,
    ) {}

    public static function make(Response $response): self
    {
        $data = $response->json('data');
        $summaries = $data['attributes']['weaponSummaries'] ?? [];

        return new self(
            accountId: $data['id'],
            platform: (string) ($data['attributes']['platform'] ?? ''),
            seasonId: (string) ($data['attributes']['seasonId'] ?? ''),
            latestMatchId: (string) ($data['attributes']['latestMatchId'] ?? ''),
            weaponSummaries: array_combine(
                array_keys($summaries),
                array_map(WeaponSummary::fromArray(...), array_keys($summaries), $summaries),
            ),
        );
    }
}
