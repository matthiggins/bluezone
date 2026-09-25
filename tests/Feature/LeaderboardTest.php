<?php

declare(strict_types=1);

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Region;
use Bluezone\Exceptions\LeaderboardNotFoundException;
use Bluezone\Requests\LeaderboardRequest;
use Saloon\Http\Faking\MockResponse;

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

it('asks for the board without a page', function () {
    $bluezone = mockBluezone([LeaderboardRequest::class => apiFixture('leaderboard')]);

    $bluezone->leaderboard()->get('pc-eu', 'division.bro.official.pc-2018-43', 'squad-fpp');

    $bluezone->getMockClient()->assertSent(fn (LeaderboardRequest $request) => $request->query()->all() === []);
});

it('takes region and mode from the request, not the echoed body', function () {
    $board = mockBluezone([LeaderboardRequest::class => MockResponse::make(['data' => [
        'type' => 'leaderboard',
        'id' => 'board',
        'attributes' => ['shardId' => 'pc-unknown', 'seasonId' => 'season', 'gameMode' => 'squad-fpp-unknown'],
    ], 'included' => []])])->leaderboard()->get(Region::PcNa, 'season', GameMode::Squad);

    expect($board->region)->toBe(Region::PcNa)
        ->and($board->gameMode)->toBe(GameMode::Squad)
        ->and($board->players)->toBeEmpty();
});

it('throws a bluezone exception when there is no such board', function () {
    mockBluezone([LeaderboardRequest::class => MockResponse::make(['errors' => [['title' => 'Not Found']]], 404)])
        ->leaderboard()
        ->get('xbox-eu', 'division.bro.official.pc-2018-43', 'squad-fpp');
})->throws(LeaderboardNotFoundException::class, 'xbox-eu');
