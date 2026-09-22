<?php

declare(strict_types=1);

use Bluezone\Enums\GameMode;
use Bluezone\Requests\LifetimeStatsRequest;
use Bluezone\Requests\RankedSeasonStatsRequest;
use Bluezone\Requests\SeasonStatsManyRequest;
use Bluezone\Requests\SeasonStatsRequest;
use Bluezone\Responses\GameModeStats;
use Bluezone\Responses\RankedGameModeStats;

const HWINN_ID = 'account.48cf00fd16c548ca9f6c6091d2c82d1c';
const TGLTN_ID = 'account.82bad0072f31455d8d9f8d834da2f2f3';
const SEASON_ID = 'division.bro.official.pc-2018-43';

it('types season stats per game mode', function () {
    $stats = mockBluezone([SeasonStatsRequest::class => apiFixture('season-stats')])
        ->player()->seasonStats('steam', SEASON_ID, HWINN_ID);

    expect($stats->seasonId)->toBe(SEASON_ID)
        ->and($stats->accountId)->toBe(HWINN_ID)
        ->and($stats->gameModeStats)->toHaveKeys(['solo', 'solo-fpp', 'duo', 'duo-fpp', 'squad', 'squad-fpp'])
        ->and($stats->forMode(GameMode::DuoFpp))->toBeInstanceOf(GameModeStats::class)
        ->and($stats->forMode('duo-fpp')->roundsPlayed)->toBe(250)
        ->and($stats->forMode('duo-fpp')->damageDealt)->toBe(128584.06)
        ->and($stats->forMode('duo-fpp')->longestKill)->toBe(440.35544)
        ->and($stats->matches['duo-fpp'])->each->toBeString();
});

it('types lifetime stats with the same mode keys as season stats', function () {
    $stats = mockBluezone([LifetimeStatsRequest::class => apiFixture('lifetime-stats')])
        ->player()->lifetimeStats('steam', HWINN_ID);

    expect($stats->gameModeStats)->toHaveKeys(['solo', 'solo-fpp', 'duo', 'duo-fpp', 'squad', 'squad-fpp'])
        ->and($stats->matches)->toHaveKeys(['solo', 'solo-fpp', 'duo', 'duo-fpp', 'squad', 'squad-fpp'])
        ->and($stats->forMode('solo-fpp')->kills)->toBe(171690)
        ->and($stats->bestRankPoint)->toBe(4501.49);
});

it('types ranked stats with tiers', function () {
    $stats = mockBluezone([RankedSeasonStatsRequest::class => apiFixture('ranked-stats')])
        ->player()->rankedSeasonStats('steam', SEASON_ID, TGLTN_ID);

    $squad = $stats->forMode(GameMode::Squad);

    expect($squad)->toBeInstanceOf(RankedGameModeStats::class)
        ->and($squad->currentTier->tier)->toBe('Gold')
        ->and($squad->currentTier->subTier)->toBe('4')
        ->and($squad->currentTier->label())->toBe('Gold 4')
        ->and($squad->currentRankPoint)->toBe(1849)
        ->and($squad->bestTier->label())->toBe('Gold 4')
        ->and($squad->bestRankPoint)->toBe(1895)
        ->and($squad->roundsPlayed)->toBe(10)
        ->and($squad->kills)->toBe(18)
        ->and($squad->deaths)->toBe(11)
        ->and($squad->dBNOs)->toBe(19)
        ->and($squad->avgRank)->toBe(11.5)
        ->and($squad->damageDealt)->toBe(2771.957);
});

it('returns null for a ranked mode never played', function () {
    $stats = mockBluezone([RankedSeasonStatsRequest::class => apiFixture('ranked-stats-empty')])
        ->player()->rankedSeasonStats('steam', SEASON_ID, HWINN_ID);

    expect($stats->gameModeStats)->toBe([])
        ->and($stats->forMode(GameMode::Squad))->toBeNull();
});

it('types batch season stats for many players', function () {
    $many = mockBluezone([SeasonStatsManyRequest::class => apiFixture('season-stats-many')])
        ->player()->seasonStatsMany('steam', SEASON_ID, GameMode::SquadFpp, [HWINN_ID, TGLTN_ID]);

    expect($many->stats->count())->toBe(2)
        ->and($many->stats->first()->forMode('squad-fpp'))->toBeInstanceOf(GameModeStats::class)
        ->and($many->stats->first()->accountId)->toBe(HWINN_ID)
        ->and($many->stats->first()->forMode('solo'))->toBeNull();
});
