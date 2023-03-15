<?php

namespace Tests\Feature;

use Bluezone\Bluezone;
use Bluezone\DTOs\Player;
use Bluezone\DTOs\PubgMatch;
use Bluezone\DTOs\SeasonStats;
use Bluezone\DTOs\Telemetry;

$seasonId = env('PUBG_TEST_SEASON_ID');
$accountId = env('PUBG_TEST_ACCOUNT_ID');
$shard = env('PUBG_TEST_SHARD');
$matchId = env('PUBG_TEST_MATCH_ID');
$bluezone = new Bluezone(env('PUBG_TEST_API_KEY'));

it('can search for a match', function () use ($bluezone, $shard, $matchId) {
    $match = $bluezone->match()->find($shard, $matchId);

    expect($match->getResponse()->successful())->toBeTrue();
    expect($match instanceof PubgMatch)->toBeTrue();

    expect($match)->toBeObject()
        ->toHaveProperties(['id', 'assetId', 'assetUrl', 'duration', 'stats']);
});

it('can get match telemetry', function () use ($bluezone, $shard, $matchId) {
    $match = $bluezone->match()->find($shard, $matchId);

    expect($match->getResponse()->successful())->toBeTrue();
    expect($match instanceof PubgMatch)->toBeTrue();
    expect($match->getTelemetry() instanceof Telemetry)->toBeTrue();
});

it('can search a single player', function () use ($bluezone, $shard) {
    $response = $bluezone->player()->search($shard, 'TGLTN');

    expect($response->getResponse()->successful())->toBeTrue();
    expect($response instanceof Player)->toBeTrue();

    expect($response)->toBeObject()
        ->toHaveProperties(['id', 'shard', 'name', 'matches']);
});

it('can search many players', function () use ($bluezone, $shard) {
    $response = $bluezone->player()->searchMany($shard, ['TGLTN', 'hwinn']);

    expect($response->getResponse()->successful())->toBeTrue();
    expect($response->players->first() instanceof Player)->toBeTrue();

    expect($response->players->first())->toBeObject()
        ->toHaveProperties(['id', 'name', 'matches']);
});

it('can request season stats', function () use ($bluezone, $seasonId, $accountId, $shard) {
    $response = $bluezone->player()->seasonStats($shard, $seasonId, $accountId);

    expect($response->getResponse()->successful())->toBeTrue();

    expect($response)->toBeObject()
        ->toHaveProperties(['seasonId', 'accountId', 'gameModeStats']);
});

it('can request ranked season stats', function () use ($bluezone, $seasonId, $accountId, $shard) {
    $response = $bluezone->player()->rankedSeasonStats($shard, $seasonId, $accountId);

    expect($response->getResponse()->successful())->toBeTrue();

    expect($response)->toBeObject()
        ->toHaveProperties(['gameModeStats']);
});

it('can request many season stats', function () use ($bluezone, $seasonId, $accountId, $shard) {
    $response = $bluezone->player()->seasonStatsMany($shard, $seasonId, 'solo-fpp', [$accountId, $accountId]);

    expect($response->getResponse()->successful())->toBeTrue();
    expect($response->stats->first() instanceof SeasonStats)->toBeTrue();

    expect($response->stats->first())->toBeObject()
        ->toHaveProperties(['seasonId', 'accountId', 'gameModeStats']);
});

it('can request lifetime stats', function () use ($bluezone, $accountId, $shard) {
    $response = $bluezone->player()->lifetimeStats($shard, $accountId);

    expect($response->getResponse()->successful())->toBeTrue();

    expect($response)->toBeObject()
        ->toHaveProperties(['accountId', 'gameModeStats', 'matches', 'bestRankPoint']);
});

it('can request many lifetime stats', function () use ($bluezone, $accountId, $shard) {
    $response = $bluezone->player()->lifetimeStatsMany($shard, 'solo-fpp', [$accountId]);

    expect($response->getResponse()->successful())->toBeTrue();

    expect($response->stats->first())->toBeObject()
        ->toHaveProperties(['accountId', 'gameModeStats', 'matches', 'bestRankPoint']);
});

it('can request weapon mastery', function () use ($bluezone, $accountId, $shard) {
    $response = $bluezone->player()->weaponMastery($shard, $accountId);

    expect($response->getResponse()->successful())->toBeTrue();

    expect($response)->toBeObject()
        ->toHaveProperties(['accountId', 'weaponSummaries']);
});

it('can request survival mastery', function () use ($bluezone, $accountId, $shard) {
    $response = $bluezone->player()->survivalMastery($shard, $accountId);

    expect($response->getResponse()->successful())->toBeTrue();

    expect($response)->toBeObject()
        ->toHaveProperties(['accountId', 'xp', 'level', 'stats']);
});
