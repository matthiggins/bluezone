<?php

declare(strict_types=1);

use Bluezone\Bluezone;
use Bluezone\Requests\ClanRequest;
use Bluezone\Requests\LeaderboardRequest;
use Bluezone\Requests\LifetimeStatsRequest;
use Bluezone\Requests\MatchRequest;
use Bluezone\Requests\PlayerAccountRequest;
use Bluezone\Requests\PlayerSearchManyRequest;
use Bluezone\Requests\PlayerSearchRequest;
use Bluezone\Requests\RankedSeasonStatsRequest;
use Bluezone\Requests\SamplesRequest;
use Bluezone\Requests\SeasonsRequest;
use Bluezone\Requests\SeasonStatsManyRequest;
use Bluezone\Requests\SeasonStatsRequest;
use Bluezone\Requests\StatusRequest;
use Bluezone\Requests\SurvivalMasteryRequest;
use Bluezone\Requests\WeaponMasteryRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\MockConfig;

const HWINN = 'account.48cf00fd16c548ca9f6c6091d2c82d1c';
const TGLTN = 'account.82bad0072f31455d8d9f8d834da2f2f3';
const SEASON = 'division.bro.official.pc-2018-43';

// Saloon\Http\Faking\Fixture::getMockResponse() throws before the record-on-response
// middleware is ever registered when throwOnMissingFixtures() is on (set globally in
// Pest.php for the rest of the suite), so recording needs it off just for this file.
beforeAll(function () {
    (new ReflectionProperty(MockConfig::class, 'throwOnMissingFixtures'))->setValue(null, false);
});

afterAll(fn () => MockConfig::throwOnMissingFixtures());

/**
 * Sends one request through a recording MockClient. On a fresh checkout with
 * PUBG_API_KEY set this hits the API and writes tests/Fixtures/{name}.json;
 * afterwards it replays the file and never touches the network.
 */
function record(string $name, string $requestClass, callable $send): void
{
    $key = getenv('PUBG_API_KEY') ?: 'replay-only';
    $bluezone = new Bluezone(apiKey: $key, requestsPerMinute: 1000);
    $bluezone->withMockClient(new MockClient([$requestClass => apiFixture($name)]));

    try {
        $send($bluezone);
    } catch (Throwable) {
        // 404 fixtures are recorded before the (Saloon or Bluezone) not-found exception propagates.
    }

    expect(file_exists(__DIR__.'/../Fixtures/'.$name.'.json'))->toBeTrue();
}

it('records player', fn () => record('player', PlayerAccountRequest::class, fn ($b) => $b->player()->find('steam', HWINN)));
it('records player-search', fn () => record('player-search', PlayerSearchRequest::class, fn ($b) => $b->player()->search('steam', 'TGLTN')));
it('records player-search-missing', fn () => record('player-search-missing', PlayerSearchRequest::class, fn ($b) => $b->player()->search('steam', 'zzzz_no_such_player_zzzz')));
it('records player-search-many', fn () => record('player-search-many', PlayerSearchManyRequest::class, fn ($b) => $b->player()->searchMany('steam', ['TGLTN', 'hwinn'])));
it('records seasons', fn () => record('seasons', SeasonsRequest::class, fn ($b) => $b->season()->all('steam')));
it('records season-stats', fn () => record('season-stats', SeasonStatsRequest::class, fn ($b) => $b->player()->seasonStats('steam', SEASON, HWINN)));
it('records season-stats-many', fn () => record('season-stats-many', SeasonStatsManyRequest::class, fn ($b) => $b->player()->seasonStatsMany('steam', SEASON, 'squad-fpp', [HWINN, TGLTN])));
it('records ranked-stats', fn () => record('ranked-stats', RankedSeasonStatsRequest::class, fn ($b) => $b->player()->rankedSeasonStats('steam', SEASON, TGLTN)));
it('records ranked-stats-empty', fn () => record('ranked-stats-empty', RankedSeasonStatsRequest::class, fn ($b) => $b->player()->rankedSeasonStats('steam', SEASON, HWINN)));
it('records lifetime-stats', fn () => record('lifetime-stats', LifetimeStatsRequest::class, fn ($b) => $b->player()->lifetimeStats('steam', HWINN)));
it('records weapon-mastery', fn () => record('weapon-mastery', WeaponMasteryRequest::class, fn ($b) => $b->player()->weaponMastery('steam', HWINN)));
it('records survival-mastery', fn () => record('survival-mastery', SurvivalMasteryRequest::class, fn ($b) => $b->player()->survivalMastery('steam', HWINN)));
it('records status', fn () => record('status', StatusRequest::class, fn ($b) => $b->status()->get()));
it('records samples', fn () => record('samples', SamplesRequest::class, fn ($b) => $b->sample()->get('steam')));
it('records leaderboard', fn () => record('leaderboard', LeaderboardRequest::class, fn ($b) => $b->leaderboard()->get('pc-eu', SEASON, 'squad-fpp')));
it('records clan', fn () => record('clan', ClanRequest::class, fn ($b) => $b->clan()->find('steam', 'clan.7e41009b212341a5a62d46430b391533')));
it('records match and match-missing', function () {
    $playerJson = json_decode(file_get_contents(__DIR__.'/../Fixtures/player.json'), true);
    $matchId = json_decode($playerJson['data'], true)['data']['relationships']['matches']['data'][0]['id'];

    record('match', MatchRequest::class, fn ($b) => $b->match()->find('steam', $matchId));
    record('match-missing', MatchRequest::class, fn ($b) => $b->match()->find('steam', '00000000-0000-0000-0000-000000000000'));
});
