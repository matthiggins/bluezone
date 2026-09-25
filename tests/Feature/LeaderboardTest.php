<?php

declare(strict_types=1);

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Region;
use Bluezone\Requests\LeaderboardRequest;

it('reads a region\'s leaderboard, sorted by rank', function () {
    $board = mockBluezone([LeaderboardRequest::class => apiFixture('leaderboard')])
        ->leaderboard()
        ->get('pc-eu', 'division.bro.official.pc-2018-43', 'squad-fpp');

    $top = $board->players->first();

    expect($board->region)->toBe(Region::PcEu)
        ->and($board->gameMode)->toBe(GameMode::SquadFpp)
        ->and($board->seasonId)->toBe('division.bro.official.pc-2018-43')
        ->and($board->players)->toHaveCount(500)
        ->and($board->players->pluck('rank')->take(3)->all())->toBe([1, 2, 3])
        ->and($top->accountId)->toStartWith('account.')
        ->and($top->tier->tier)->not->toBe('Unranked')
        ->and($top->rankPoints)->toBeGreaterThan($board->players->last()->rankPoints);
});
