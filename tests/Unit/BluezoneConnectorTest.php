<?php

namespace Tests\Feature;

use Bluezone\Bluezone;
use Bluezone\Resources\MatchResource;
use Bluezone\Resources\PlayerResource;
use Bluezone\Resources\SeasonResource;

it('can be instantiated', function () {
    $bluezone = new Bluezone('test-api-key');
    expect($bluezone)->toBeInstanceOf(Bluezone::class);
});

it('resolves the base URL', function () {
    $bluezone = new Bluezone('test-api-key');
    expect($bluezone->resolveBaseUrl())->toBe('https://api.pubg.com');
});

it('returns a MatchResource object', function () {
    $bluezone = new Bluezone('test-api-key');
    $matchResource = $bluezone->match();
    expect($matchResource)->toBeInstanceOf(MatchResource::class);
});

it('returns a PlayerResource object', function () {
    $bluezone = new Bluezone('test-api-key');
    $playerResource = $bluezone->player();
    expect($playerResource)->toBeInstanceOf(PlayerResource::class);
});

it('returns a SeasonResource object', function () {
    $bluezone = new Bluezone('test-api-key');
    $seasonResource = $bluezone->season();
    expect($seasonResource)->toBeInstanceOf(SeasonResource::class);
});
