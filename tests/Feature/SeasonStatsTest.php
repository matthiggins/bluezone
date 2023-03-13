<?php

namespace Tests\Feature;

use Bluezone\PubgApi;

it('can request season stats', function () {
    $pubgApi = new PubgApi(env('PUBG_TEST_API_KEY'));
    $response = $pubgApi->player()->seasonStats('steam', env('PUBG_TEST_SEASON_ID'), env('PUBG_TEST_ACCOUNT_ID'));

    expect($response->successful())->toBeTrue();

    expect($response->dto())
        ->toBeObject()
        ->toHaveProperties(['seasonId', 'accountId', 'gameModeStats']);
});
it('can request survival mastery', function () {
    $pubgApi = new PubgApi(env('PUBG_TEST_API_KEY'));
    $response = $pubgApi->mastery()->survival('steam', env('PUBG_TEST_ACCOUNT_ID'));

    expect((bool) $response->successful())->toBeTrue();

    expect($response->dto())
        ->toBeObject()
        ->toHaveProperties(['accountId', 'xp', 'level', 'stats']);
});
