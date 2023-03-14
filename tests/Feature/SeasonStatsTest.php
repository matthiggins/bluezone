<?php

namespace Tests\Feature;

use Bluezone\Bluezone;

it('can request season stats', function () {
    $bluezone = new Bluezone(env('PUBG_TEST_API_KEY'));
    $response = $bluezone->player()->seasonStats('steam', env('PUBG_TEST_SEASON_ID'), env('PUBG_TEST_ACCOUNT_ID'));

    expect($response->getResponse()->successful())->toBeTrue();

    expect($response)
        ->toBeObject()
        ->toHaveProperties(['seasonId', 'accountId', 'gameModeStats']);
});
it('can request survival mastery', function () {
    $bluezone = new Bluezone(env('PUBG_TEST_API_KEY'));
    $response = $bluezone->player()->survivalMastery('steam', env('PUBG_TEST_ACCOUNT_ID'));

    expect((bool) $response->getResponse()->successful())->toBeTrue();

    expect($response)
        ->toBeObject()
        ->toHaveProperties(['accountId', 'xp', 'level', 'stats']);
});
