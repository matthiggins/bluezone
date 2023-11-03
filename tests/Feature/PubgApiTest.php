<?php

namespace Tests\Feature;

use Bluezone\Bluezone;
use Bluezone\DTOs\Player;
use Bluezone\DTOs\PlayerMatchStats;
use Bluezone\DTOs\PubgMatch;
use Bluezone\DTOs\RankedSeasonStats;
use Bluezone\DTOs\SeasonStats;
use Illuminate\Support\Collection;

$seasonId = env('PUBG_TEST_SEASON_ID');
$accountId = env('PUBG_TEST_ACCOUNT_ID');
$shard = env('PUBG_TEST_SHARD');
$matchId = env('PUBG_TEST_MATCH_ID');
$clanId = env('PUBG_TEST_CLAN_ID');
$bluezone = new Bluezone(env('PUBG_TEST_API_KEY'));

it('can search for a match', function () use ($bluezone, $shard, $matchId) {
    $match = $bluezone->match()->find($shard, $matchId);

    expect($match instanceof PubgMatch)->toBeTrue();

    expect($match)->toBeObject()
        ->toHaveProperties(['id', 'assetId', 'assetUrl', 'duration', 'stats']);
});

it('can get match stats for a single player', function () use ($bluezone, $shard, $matchId, $accountId) {
    $match = $bluezone->match()->find($shard, $matchId);

    $playerStats = $match->statsForPlayer($accountId);

    expect($match instanceof PubgMatch)->toBeTrue();
    expect($playerStats instanceof PlayerMatchStats)->toBeTrue();

    expect($playerStats)->toBeObject()
        ->toHaveProperties(['playerId', 'name', 'kills', 'damageDealt', 'winPlace']);
});

it('can search a single player', function () use ($bluezone, $shard) {
    $response = $bluezone->player()->search($shard, 'TGLTN');

    expect($response instanceof Player)->toBeTrue();

    expect($response)->toBeObject()
        ->toHaveProperties(['id', 'shard', 'name', 'matches']);
});

it('can get player recent matches', function () use ($bluezone, $shard) {
    $player = $bluezone->player()->search($shard, 'TGLTN');

    $matches = $bluezone->player()->recentMatches($player, 5);

    expect($matches instanceof Collection)->toBeTrue();
    expect($matches->first() instanceof PubgMatch)->toBeTrue();

    expect($matches->first())->toBeObject()
        ->toHaveProperties(['id', 'shard', 'assetId', 'matchType']);
});

it('can search many players', function () use ($bluezone, $shard) {
    $response = $bluezone->player()->searchMany($shard, ['TGLTN', 'hwinn']);

    expect($response->players->first() instanceof Player)->toBeTrue();

    expect($response->players->first())->toBeObject()
        ->toHaveProperties(['id', 'name', 'matches']);
});

it('can request season stats', function () use ($bluezone, $seasonId, $accountId, $shard) {
    $response = $bluezone->player()->seasonStats($shard, $seasonId, $accountId);


    expect($response)->toBeObject()
        ->toHaveProperties(['seasonId', 'accountId', 'gameModeStats']);
});

it('can request ranked season stats', function () use ($bluezone, $seasonId, $accountId, $shard) {
    $response = $bluezone->player()->rankedSeasonStats($shard, $seasonId, $accountId);


    expect($response)->toBeObject()
        ->toHaveProperties(['gameModeStats']);
});

it('can request many season stats', function () use ($bluezone, $seasonId, $accountId, $shard) {
    $response = $bluezone->player()->seasonStatsMany($shard, $seasonId, 'solo-fpp', [$accountId, $accountId]);

    expect($response->stats->first() instanceof SeasonStats)->toBeTrue();

    expect($response->stats->first())->toBeObject()
        ->toHaveProperties(['seasonId', 'accountId', 'gameModeStats']);
});

it('can request many ranked season stats', function () use ($bluezone, $seasonId, $accountId, $shard) {
    $response = $bluezone->player()->rankedSeasonStatsMany($shard, $seasonId, [$accountId, $accountId]);

    expect($response->stats->first() instanceof RankedSeasonStats)->toBeTrue();

    expect($response->stats->first())->toBeObject()
        ->toHaveProperties(['seasonId', 'accountId', 'gameModeStats']);
});


it('can request lifetime stats', function () use ($bluezone, $accountId, $shard) {
    $response = $bluezone->player()->lifetimeStats($shard, $accountId);

    expect($response)->toBeObject()
        ->toHaveProperties(['accountId', 'gameModeStats', 'matches', 'bestRankPoint']);
});

it('can request many lifetime stats', function () use ($bluezone, $accountId, $shard) {
    $response = $bluezone->player()->lifetimeStatsMany($shard, 'solo-fpp', [$accountId]);

    expect($response->stats->first())->toBeObject()
        ->toHaveProperties(['accountId', 'gameModeStats', 'matches', 'bestRankPoint']);
});

it('can request weapon mastery', function () use ($bluezone, $accountId, $shard) {
    $response = $bluezone->player()->weaponMastery($shard, $accountId);

    expect($response)->toBeObject()
        ->toHaveProperties(['accountId', 'weaponSummaries']);
});

it('can request survival mastery', function () use ($bluezone, $accountId, $shard) {
    $response = $bluezone->player()->survivalMastery($shard, $accountId);

    expect($response)->toBeObject()
        ->toHaveProperties(['accountId', 'xp', 'level', 'stats']);
});

it('can request clan details', function () use ($bluezone, $clanId, $shard) {
    $response = $bluezone->clan()->find($shard, $clanId);

    expect($response)->toBeObject()
        ->toHaveProperties(['id', 'shard', 'name', 'tag', 'level', 'memberCount']);
});

it('can get api status', function () use ($bluezone) {
    $response = $bluezone->status()->get();

    expect($response)->toBeObject()
        ->toHaveProperties(['status']);
});
