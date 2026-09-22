<?php

declare(strict_types=1);

use Bluezone\Responses\PlayerMatchStats;

/** The API returns floats for timeSurvived in some modes, and the recorded fixture only ever has ints. */
it('casts float payload values into the typed fields', function () {
    $stats = PlayerMatchStats::fromArray([
        'DBNOs' => 2.0,
        'assists' => 1.0,
        'boosts' => 12,
        'damageDealt' => 746.54486,
        'deathType' => 'alive',
        'headshotKills' => 1,
        'heals' => 10,
        'killPlace' => 2,
        'killStreaks' => 2,
        'kills' => 7.0,
        'longestKill' => 205,
        'name' => 'DarlingEllie',
        'playerId' => 'account.64e6ef202928486295bf31fb03f5e186',
        'revives' => 0,
        'rideDistance' => 9484.052,
        'roadKills' => 0,
        'swimDistance' => 0,
        'teamKills' => 0,
        'timeSurvived' => 1234.5,
        'vehicleDestroys' => 0,
        'walkDistance' => 3045.4321,
        'weaponsAcquired' => 18.0,
        'winPlace' => 1,
    ]);

    expect($stats->timeSurvived)->toBe(1234.5)
        ->and($stats->dBNOs)->toBe(2)
        ->and($stats->assists)->toBe(1)
        ->and($stats->kills)->toBe(7)
        ->and($stats->weaponsAcquired)->toBe(18)
        ->and($stats->longestKill)->toBe(205.0)
        ->and($stats->swimDistance)->toBe(0.0)
        ->and($stats->damageDealt)->toBe(746.54486);
});

it('defaults missing stats rather than erroring', function () {
    $stats = PlayerMatchStats::fromArray(['playerId' => 'account.abc']);

    expect($stats->playerId)->toBe('account.abc')
        ->and($stats->kills)->toBe(0)
        ->and($stats->timeSurvived)->toBe(0.0)
        ->and($stats->deathType)->toBe('');
});
