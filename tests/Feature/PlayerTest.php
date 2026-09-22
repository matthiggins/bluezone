<?php

declare(strict_types=1);

use Bluezone\Enums\Shard;
use Bluezone\Exceptions\PlayerNotFoundException;
use Bluezone\Requests\PlayerAccountRequest;
use Bluezone\Requests\PlayerAccountRequest as FindRequest;
use Bluezone\Requests\PlayerSearchManyRequest;
use Bluezone\Requests\PlayerSearchRequest;
use Bluezone\Responses\Player;
use Bluezone\Responses\PlayerCollection;
use Saloon\Http\Faking\MockResponse;

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

it('throws PlayerNotFoundException when a name is unknown', function () {
    try {
        mockBluezone([PlayerSearchRequest::class => apiFixture('player-search-missing')])
            ->player()->search('steam', 'zzzz_no_such_player_zzzz');
        $this->fail('expected exception');
    } catch (PlayerNotFoundException $e) {
        expect($e->shard)->toBe(Shard::Steam)
            ->and($e->identifier)->toBe('zzzz_no_such_player_zzzz')
            ->and($e->getMessage())->not->toContain('test-api-key');
    }
});

it('throws PlayerNotFoundException when an account id is unknown', function () {
    mockBluezone([FindRequest::class => MockResponse::make(['errors' => [['title' => 'Not Found']]], 404)])
        ->player()->find(Shard::Steam, 'account.missing');
})->throws(PlayerNotFoundException::class);

it('url-encodes player names in the query string', function () {
    $bluezone = mockBluezone([PlayerSearchManyRequest::class => apiFixture('player-search-many')]);
    $bluezone->player()->searchMany('steam', ['a b', 'c&d']);

    // getLastPendingRequest()->getUrl() excludes the query string; the PSR-7 request carries it.
    expect((string) $bluezone->getMockClient()->getLastResponse()->getPsrRequest()->getUri())
        ->toContain('filter%5BplayerNames%5D=a+b%2Cc%26d');
});
