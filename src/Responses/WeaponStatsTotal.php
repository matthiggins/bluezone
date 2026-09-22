<?php

declare(strict_types=1);

namespace Bluezone\Responses;

final class WeaponStatsTotal extends PubgResponse
{
    public function __construct(
        public readonly ?int $mostDefeatsInAGame,
        public readonly ?int $defeats,
        public readonly ?float $mostDamagePlayerInAGame,
        public readonly ?float $damagePlayer,
        public readonly ?int $mostHeadShotsInAGame,
        public readonly ?int $headShots,
        public readonly ?float $longestDefeat,
        public readonly ?int $longRangeDefeats,
        public readonly ?int $kills,
        public readonly ?int $mostKillsInAGame,
        public readonly ?int $groggies,
        public readonly ?int $mostGroggiesInAGame,
        public readonly ?float $longestKill,
    ) {}

    /** @param array<string, mixed> $d */
    public static function fromArray(array $d): self
    {
        return new self(
            mostDefeatsInAGame: isset($d['MostDefeatsInAGame']) ? (int) $d['MostDefeatsInAGame'] : null,
            defeats: isset($d['Defeats']) ? (int) $d['Defeats'] : null,
            mostDamagePlayerInAGame: isset($d['MostDamagePlayerInAGame']) ? (float) $d['MostDamagePlayerInAGame'] : null,
            damagePlayer: isset($d['DamagePlayer']) ? (float) $d['DamagePlayer'] : null,
            mostHeadShotsInAGame: isset($d['MostHeadShotsInAGame']) ? (int) $d['MostHeadShotsInAGame'] : null,
            headShots: isset($d['HeadShots']) ? (int) $d['HeadShots'] : null,
            longestDefeat: isset($d['LongestDefeat']) ? (float) $d['LongestDefeat'] : null,
            longRangeDefeats: isset($d['LongRangeDefeats']) ? (int) $d['LongRangeDefeats'] : null,
            kills: isset($d['Kills']) ? (int) $d['Kills'] : null,
            mostKillsInAGame: isset($d['MostKillsInAGame']) ? (int) $d['MostKillsInAGame'] : null,
            groggies: isset($d['Groggies']) ? (int) $d['Groggies'] : null,
            mostGroggiesInAGame: isset($d['MostGroggiesInAGame']) ? (int) $d['MostGroggiesInAGame'] : null,
            longestKill: isset($d['LongestKill']) ? (float) $d['LongestKill'] : null,
        );
    }
}
