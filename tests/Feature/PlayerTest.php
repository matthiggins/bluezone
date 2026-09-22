<?php

declare(strict_types=1);

use Bluezone\Requests\PlayerAccountRequest;
use Bluezone\Requests\PlayerSearchManyRequest;
use Bluezone\Requests\PlayerSearchRequest;
use Bluezone\Responses\Player;
use Bluezone\Responses\PlayerCollection;

it('finds a player by account id', function () {
    $player = mockBluezone([PlayerAccountRequest::class => apiFixture('player')])
        ->player()->find('steam', 'account.48cf00fd16c548ca9f6c6091d2c82d1c');

    expect($player)->toBeInstanceOf(Player::class)
        ->and($player->id)->toBe('account.48cf00fd16c548ca9f6c6091d2c82d1c')
        ->and($player->name)->toBe('CorkyCorc')
        ->and($player->shard)->toBe('steam')
        ->and($player->matches->count())->toBeGreaterThan(0)
        ->and($player->matches->first())->toBeString();
});

it('searches one player by name', function () {
    $player = mockBluezone([PlayerSearchRequest::class => apiFixture('player-search')])
        ->player()->search('steam', 'TGLTN');

    expect($player->name)->toBe('TGLTN')
        ->and($player->id)->toBe('account.82bad0072f31455d8d9f8d834da2f2f3');
});

it('searches many players by name', function () {
    $players = mockBluezone([PlayerSearchManyRequest::class => apiFixture('player-search-many')])
        ->player()->searchMany('steam', ['TGLTN', 'hwinn']);

    expect($players)->toBeInstanceOf(PlayerCollection::class)
        ->and($players->players->pluck('name')->sort()->values()->all())->toBe(['TGLTN', 'hwinn']);
});
