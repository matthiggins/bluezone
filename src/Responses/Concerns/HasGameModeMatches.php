<?php

declare(strict_types=1);

namespace Bluezone\Responses\Concerns;

use Bluezone\Enums\GameMode;
use Bluezone\Responses\GameModeStats;

trait HasGameModeMatches
{
    /**
     * Match ids per game mode, keyed by the GameMode value (kebab-case).
     *
     * @param  array<string, mixed>  $relationships
     * @return array<string, array<int, string>>
     */
    protected static function matchesByMode(array $relationships): array
    {
        $keys = [
            'solo' => 'matchesSolo', 'solo-fpp' => 'matchesSoloFPP',
            'duo' => 'matchesDuo', 'duo-fpp' => 'matchesDuoFPP',
            'squad' => 'matchesSquad', 'squad-fpp' => 'matchesSquadFPP',
        ];

        $matches = [];

        foreach ($keys as $mode => $relationship) {
            $matches[$mode] = array_map(
                fn (array $m): string => $m['id'],
                $relationships[$relationship]['data'] ?? [],
            );
        }

        return $matches;
    }

    /**
     * @param  array<string, array<string, mixed>>  $gameModeStats
     * @return array<string, GameModeStats>
     */
    protected static function statsByMode(array $gameModeStats): array
    {
        return array_map(GameModeStats::fromArray(...), $gameModeStats);
    }

    public function forMode(GameMode|string $mode): ?GameModeStats
    {
        return $this->gameModeStats[GameMode::resolve($mode)->value] ?? null;
    }
}
