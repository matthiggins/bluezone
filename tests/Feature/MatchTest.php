<?php

declare(strict_types=1);

use Bluezone\Exceptions\MatchNotFoundException;
use Bluezone\Requests\MatchRequest;
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
