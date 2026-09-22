<?php

declare(strict_types=1);

use Bluezone\Exceptions\MatchNotFoundException;
use Bluezone\Requests\MatchRequest;
use Bluezone\Responses\MatchRoster;
use Bluezone\Responses\PlayerMatchStats;

it('builds a match with translated map name and per-participant stats', function () {
    $match = mockBluezone([MatchRequest::class => apiFixture('match')])->match()->find('steam', 'any');

    expect($match->mapName)->toBe('Taego')
        ->and($match->gameMode)->toBe('duo-fpp')
        ->and($match->matchType)->toBe('official')
        ->and($match->duration)->toBe(1686)
        ->and($match->assetUrl)->toStartWith('https://telemetry-cdn.pubg.com/')
        ->and($match->stats->first())->toBeInstanceOf(PlayerMatchStats::class)
        ->and($match->stats->first()->winPlace)->toBe(1)
        ->and($match->totalPlayers())->toBeGreaterThan(50);
});

it('throws MatchNotFoundException on 404', function () {
    mockBluezone([MatchRequest::class => apiFixture('match-missing')])->match()->find('steam', '00000000-0000-0000-0000-000000000000');
})->throws(MatchNotFoundException::class);

it('builds rosters with boolean won and participant ids', function () {
    $match = mockBluezone([MatchRequest::class => apiFixture('match')])->match()->find('steam', 'any');

    $winner = $match->rosters->firstWhere('rank', 1);

    expect($winner)->toBeInstanceOf(MatchRoster::class)
        ->and($winner->won)->toBeTrue()
        ->and($match->rosters->firstWhere('rank', 2)->won)->toBeFalse()
        ->and($winner->participantIds)->not->toBeEmpty()
        ->and($match->isCustomMatch)->toBeFalse()
        ->and($match->totalTeams())->toBe(52)
        ->and($match->stats->first()->dBNOs)->toBe(4);

    $someone = $match->stats->first()->playerId;
    expect($match->rosterForPlayer($someone)?->participantIds)->toContain($match->stats->keys()->first())
        ->and($match->teammatesOf($someone))->toHaveCount(1)
        ->and($match->teammatesOf($someone)->pluck('playerId'))->not->toContain($someone);
});
