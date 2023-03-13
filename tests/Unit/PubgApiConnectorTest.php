<?php

namespace Tests\Feature;

use Bluezone\PubgApi;
use Bluezone\Resources\MasteryResource;
use Bluezone\Resources\MatchResource;
use Bluezone\Resources\PlayerResource;
use Bluezone\Resources\SeasonResource;

it('can be instantiated', function () {
    $apiKey = 'test-api-key';
    $pubgApi = new PubgApi($apiKey);
    expect($pubgApi)->toBeInstanceOf(PubgApi::class);
});

it('resolves the base URL', function () {
    $pubgApi = new PubgApi('test-api-key');
    expect($pubgApi->resolveBaseUrl())->toBe('https://api.pubg.com');
});

// it('returns the default headers', function () {
//     $pubgApi = new PubgApi('test-api-key');
//     expect($pubgApi->defaultHeaders())->toBe([
//         'Content-Type' => 'application/json',
//         'Accept' => 'application/vnd.api+json',
//     ]);
// });

it('returns a MasteryResource object', function () {
    $pubgApi = new PubgApi('test-api-key');
    $masteryResource = $pubgApi->mastery();
    expect($masteryResource)->toBeInstanceOf(MasteryResource::class);
});

it('returns a MatchResource object', function () {
    $pubgApi = new PubgApi('test-api-key');
    $matchResource = $pubgApi->match();
    expect($matchResource)->toBeInstanceOf(MatchResource::class);
});

it('returns a PlayerResource object', function () {
    $pubgApi = new PubgApi('test-api-key');
    $playerResource = $pubgApi->player();
    expect($playerResource)->toBeInstanceOf(PlayerResource::class);
});

it('returns a SeasonResource object', function () {
    $pubgApi = new PubgApi('test-api-key');
    $seasonResource = $pubgApi->season();
    expect($seasonResource)->toBeInstanceOf(SeasonResource::class);
});
