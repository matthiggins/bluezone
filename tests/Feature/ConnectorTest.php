<?php

declare(strict_types=1);

use Bluezone\Bluezone;
use Bluezone\Enums\Shard;
use Bluezone\Requests\PlayerAccountRequest;
use Bluezone\Resources\MatchResource;
use Bluezone\Resources\PlayerResource;
use Bluezone\Resources\SeasonResource;
use Saloon\Http\Faking\MockResponse;

it('resolves the PUBG base url', function () {
    expect((new Bluezone('test-api-key'))->resolveBaseUrl())->toBe('https://api.pubg.com');
});

it('exposes resources', function () {
    $bluezone = new Bluezone('test-api-key');

    expect($bluezone->player())->toBeInstanceOf(PlayerResource::class)
        ->and($bluezone->match())->toBeInstanceOf(MatchResource::class)
        ->and($bluezone->season())->toBeInstanceOf(SeasonResource::class);
});

it('sends the bearer token and json:api accept header', function () {
    $bluezone = mockBluezone([
        PlayerAccountRequest::class => MockResponse::make(['data' => [
            'id' => 'account.1', 'attributes' => ['name' => 'x', 'shardId' => 'steam'],
            'relationships' => ['matches' => ['data' => []]],
        ]]),
    ]);

    $bluezone->player()->find('steam', 'account.1');

    $request = $bluezone->getMockClient()->getLastPendingRequest();

    expect($request->headers()->get('Authorization'))->toBe('Bearer test-api-key')
        ->and($request->headers()->get('Accept'))->toBe('application/vnd.api+json')
        ->and($request->getUrl())->toBe('https://api.pubg.com/shards/steam/players/account.1');
});

it('resolves a Shard enum to the same URL as its string value', function () {
    $mock = fn () => mockBluezone([
        PlayerAccountRequest::class => MockResponse::make(['data' => [
            'id' => 'account.1', 'attributes' => ['name' => 'x', 'shardId' => 'steam'],
            'relationships' => ['matches' => ['data' => []]],
        ]]),
    ]);

    $stringShard = $mock();
    $stringShard->player()->find('steam', 'account.1');

    $enumShard = $mock();
    $enumShard->player()->find(Shard::Steam, 'account.1');

    expect($enumShard->getMockClient()->getLastPendingRequest()->getUrl())
        ->toBe($stringShard->getMockClient()->getLastPendingRequest()->getUrl());
});
