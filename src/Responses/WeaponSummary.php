<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Support\Dictionary;

final class WeaponSummary extends PubgResponse
{
    /** @param array<int, WeaponMedal> $medals */
    public function __construct(
        public readonly string $itemId,
        public readonly string $name,
        public readonly int $xpTotal,
        public readonly int $levelCurrent,
        public readonly int $tierCurrent,
        public readonly WeaponStatsTotal $statsTotal,
        public readonly WeaponStatsTotal $officialStatsTotal,
        public readonly WeaponStatsTotal $competitiveStatsTotal,
        public readonly array $medals,
    ) {}

    /** @param array<string, mixed> $d */
    public static function fromArray(string $itemId, array $d): self
    {
        return new self(
            itemId: $itemId,
            name: Dictionary::get('telemetry/item/itemId.json', $itemId),
            xpTotal: (int) ($d['XPTotal'] ?? 0),
            levelCurrent: (int) ($d['LevelCurrent'] ?? 0),
            tierCurrent: (int) ($d['TierCurrent'] ?? 0),
            statsTotal: WeaponStatsTotal::fromArray($d['StatsTotal'] ?? []),
            officialStatsTotal: WeaponStatsTotal::fromArray($d['OfficialStatsTotal'] ?? []),
            competitiveStatsTotal: WeaponStatsTotal::fromArray($d['CompetitiveStatsTotal'] ?? []),
            medals: array_map(WeaponMedal::fromArray(...), $d['Medals'] ?? []),
        );
    }
}
