<?php

namespace Tests\Feature;

use Bluezone\Bluezone;
use Bluezone\Resources\MatchResource;
use Bluezone\Resources\PlayerResource;
use Bluezone\Resources\SeasonResource;

$bluezone = new Bluezone('test-api-key');

it('can be instantiated', function () use ($bluezone) {
    expect($bluezone)->toBeInstanceOf(Bluezone::class);
});

it('resolves the base URL', function () use ($bluezone) {
    expect($bluezone->resolveBaseUrl())->toBe('https://api.pubg.com');
});

it('returns a MatchResource object', function () use ($bluezone) {
    expect($bluezone->match())->toBeInstanceOf(MatchResource::class);
});

it('returns a PlayerResource object', function () use ($bluezone) {
    expect($bluezone->player())->toBeInstanceOf(PlayerResource::class);
});

it('returns a SeasonResource object', function () use ($bluezone) {
    expect($bluezone->season())->toBeInstanceOf(SeasonResource::class);
});
