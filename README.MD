![bluezone-banner](https://github.com/matthiggins/bluezone/assets/422780/e309788b-b3bd-47fb-9df3-edaa2d3f6a52)

# BLUEZONE : A PHP SDK for the PUBG API

[![Version](http://poser.pugx.org/matthiggins/bluezone/version)](https://packagist.org/packages/matthiggins/bluezone)
[![PHP Version Require](http://poser.pugx.org/matthiggins/bluezone/require/php)](https://packagist.org/packages/matthiggins/bluezone)
[![License](http://poser.pugx.org/matthiggins/bluezone/license)](https://packagist.org/packages/matthiggins/bluezone)

BLUEZONE is a PHP SDK for the [PUBG API](https://developer.pubg.com/). It covers players, matches, seasons, clans, ranked and lifetime stats, weapon and survival mastery, and it parses match telemetry files into typed event objects.

It is built on [Saloon 4](https://docs.saloon.dev/): every response is a data transfer object, and every Saloon feature (mocking, middleware, retries) is available.

**Links:** [PUBG API](https://developer.pubg.com/) · [PUBG API docs](https://documentation.pubg.com/) · [Saloon](https://docs.saloon.dev/) · [Laravel Collections](https://laravel.com/docs/12.x/collections)

## Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Creating a client](#creating-a-client)
- [Rate limiting](#rate-limiting)
- [Shards and game modes](#shards-and-game-modes)
- [Resources](#resources)
- [Exceptions](#exceptions)
- [Match telemetry](#match-telemetry)
- [Telemetry events](#telemetry-events)
- [Testing](#testing)

## Requirements

- PHP 8.3 or 8.4
- Saloon 4 (installed as a dependency)
- A PUBG API key from the [PUBG Developer Portal](https://developer.pubg.com/)

## Installation

```
composer require matthiggins/bluezone
```

## Creating a client

```php
use Bluezone\Bluezone;

$bluezone = new Bluezone($apiKey);
```

The constructor is:

```php
new Bluezone(string $apiKey, ?RateLimitStore $store = null, int $requestsPerMinute = 10);
```

`$requestsPerMinute` should match the quota on your key (10 for a standard key). Connect and request timeouts are 10s and 15s.

## Rate limiting

Bluezone enforces your quota client-side with the [Saloon rate limit plugin](https://docs.saloon.dev/plugins/rate-limit-handler), so you fail fast instead of burning 429s.

The default store is Saloon's `MemoryStore`, which only tracks one process. In a queue worker, a web app, or anything else running more than one process at a time, pass a shared store:

```php
use Bluezone\Bluezone;
use Saloon\RateLimitPlugin\Stores\PredisStore;

$bluezone = new Bluezone($apiKey, new PredisStore($predis), requestsPerMinute: 100);
```

`LaravelCacheStore` and `FileStore` work as well. Both the spent local budget and a 429 from the API raise `Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException`; the 429 handler runs first, so Saloon's own `TooManyRequestsException` is not what you catch.

```php
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;

try {
    $player = $bluezone->player()->search('steam', 'TGLTN');
} catch (RateLimitReachedException $e) {
    $waitSeconds = $e->getLimit()->getRemainingSeconds();
}
```

`recentMatches()` (and `recentCasualMatches()` / `recentRankedMatches()`) issues one request per match id, and `rankedSeasonStatsMany()` one per account id, so a default `$limit` of 20 spends twice a standard key's 10-per-minute budget: keep `$limit` under your per-minute budget, or pass the budget your key actually has.

Turn the plugin off in tests with `$bluezone->useRateLimitPlugin(false)`.

## Shards and game modes

Every resource method takes `Bluezone\Enums\Shard` or its string value, and `Bluezone\Enums\GameMode` or its string value.

```php
use Bluezone\Enums\GameMode;
use Bluezone\Enums\Shard;

$bluezone->player()->search(Shard::Steam, 'TGLTN');
$bluezone->player()->search('steam', 'TGLTN');   // identical

Shard::Steam->label();          // 'PC (Steam)'
Shard::Psn->isConsole();        // true
GameMode::SquadFpp->label();    // 'Squad FPP'
GameMode::SquadFpp->teamSize(); // 4
GameMode::battleRoyale();       // the six BR modes
```

Shards: `steam`, `xbox`, `psn`, `kakao`, `console`, `tournament`. Game modes: `solo`, `solo-fpp`, `duo`, `duo-fpp`, `squad`, `squad-fpp`.

Leaderboards are the one endpoint still keyed by platform-region, so they take `Bluezone\Enums\Region` (`pc-eu`, `pc-na`, `pc-as`, `pc-sea`, `pc-kakao`, …) instead of a shard.

## Resources

Every method returns a typed DTO from `Bluezone\Responses`.

```php
// Bluezone\Responses\Status
$status = $bluezone->status()->get();
$status->isOnline();
$status->version;             // null: the live endpoint currently returns neither version nor releasedAt

// Bluezone\Responses\Seasons
$seasons = $bluezone->season()->all('steam');
$seasons->seasons;          // Collection<Season>
$seasons->currentSeason();  // ?Season

// Bluezone\Responses\Clan
$clan = $bluezone->clan()->find('steam', $clanId);

// Bluezone\Responses\Player
$player = $bluezone->player()->find('steam', $accountId);
$player = $bluezone->player()->search('steam', $playerName); // exact in-game name
$player->matches;                                            // Collection<string> of match ids

// Bluezone\Responses\PlayerCollection (up to 10 names)
$players = $bluezone->player()->searchMany('steam', [$nameOne, $nameTwo]);

// Collection<PubgMatch>, one request per match
$matches = $bluezone->player()->recentMatches($player, limit: 20);
$ranked = $bluezone->player()->recentRankedMatches($player);
$casual = $bluezone->player()->recentCasualMatches($player);

// Bluezone\Responses\SeasonStats / SeasonStatsCollection
$seasonStats = $bluezone->player()->seasonStats('steam', $seasonId, $accountId);
$seasonStats->forMode(GameMode::SquadFpp);   // ?GameModeStats
$seasonStats->matches['squad-fpp'];          // match ids, kebab-case keys
$manyStats = $bluezone->player()->seasonStatsMany('steam', $seasonId, 'squad-fpp', [$accountId, $otherId]);

// Bluezone\Responses\RankedSeasonStats / RankedSeasonStatsCollection
$ranked = $bluezone->player()->rankedSeasonStats('steam', $seasonId, $accountId);
$ranked->forMode('squad-fpp')?->currentTier->label();   // 'Diamond 4'
$rankedMany = $bluezone->player()->rankedSeasonStatsMany('steam', $seasonId, [$accountId, $otherId]);

// Bluezone\Responses\LifetimeStats / LifetimeStatsCollection
$lifetime = $bluezone->player()->lifetimeStats('steam', $accountId);
$lifetime->forMode('solo-fpp')?->kills;
$lifetimeMany = $bluezone->player()->lifetimeStatsMany('steam', 'squad-fpp', [$accountId, $otherId]);

// Bluezone\Responses\WeaponMastery
$weapons = $bluezone->player()->weaponMastery('steam', $accountId);
$weapons->weaponSummaries;                   // array<string itemId, WeaponSummary>
$weapons->weaponSummaries['Item_Weapon_AK47_C']->statsTotal->kills;

// Bluezone\Responses\SurvivalMastery
$survival = $bluezone->player()->survivalMastery('steam', $accountId);
$survival->stats;                            // array<string key, SurvivalStat>
$survival->stats['damageDealt']->careerBest;

// Bluezone\Responses\PubgMatch
$match = $bluezone->match()->find('steam', $matchId);
$match->rosters;                             // Collection<MatchRoster>, sorted by rank
$match->statsForPlayer($accountId);          // ?PlayerMatchStats, null when the id did not play
$match->rosterForPlayer($accountId)?->won;
$match->teammatesOf($accountId);             // Collection<PlayerMatchStats>
$match->isRanked();
$match->totalPlayers();
$match->totalBots();
$match->botPercent();

// Bluezone\Responses\Samples: a random sample of recent public matches (hundreds of ids)
$samples = $bluezone->samples()->get('steam');                          // the last 24 hours
$samples = $bluezone->samples()->get('steam', now()->subHours(6));      // from a given time, within 14 days
$samples->matchIds;                          // Collection<string>

// Bluezone\Responses\Leaderboard: the top 500, in one page, sorted by rank
$board = $bluezone->leaderboard()->get('pc-eu', $seasonId, 'squad-fpp');
$board->players;                             // Collection<LeaderboardPlayer>
$board->players->first()->tier->label();     // 'Master 1'
```

`rankedSeasonStatsMany()` is one request per account id: the PUBG API has no batch ranked endpoint.

Samples and leaderboards are metered against the rate limit; matches are not. A leaderboard row's `kda` and `killDeathRatio` are always 0 from the API, so `LeaderboardPlayer` leaves them out.

## Exceptions

Bluezone throws `Bluezone\Exceptions\BluezoneException` subclasses for the cases the API reports as a bare 404:

```php
use Bluezone\Exceptions\MatchNotFoundException;
use Bluezone\Exceptions\PlayerNotFoundException;

try {
    $player = $bluezone->player()->search('steam', $name);
} catch (PlayerNotFoundException $e) {
    $e->shard;       // Shard
    $e->identifier;  // the name or account id that was not found
}

try {
    $match = $bluezone->match()->find('steam', $matchId);
} catch (MatchNotFoundException $e) {
    // PUBG only keeps matches for about 14 days
}
```

| Exception | Thrown when |
|---|---|
| `PlayerNotFoundException` | `player()->find()`, `search()` or `searchMany()` gets a 404, or the search matched no player |
| `MatchNotFoundException` | `match()->find()` gets a 404 |
| `InvalidTelemetryUrlException` | a telemetry url is not on `telemetry-cdn.pubg.com` |
| `InvalidTelemetryException` | a telemetry body is not decodable JSON |
| `Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException` | the local budget is spent, or the API answered 429 |
| `ValueError` | `Shard::resolve()` or `GameMode::resolve()` is given a string that is not a shard or game mode |

Everything else surfaces as a Saloon exception (`UnauthorizedException`, `ServiceUnavailableException`, `FatalRequestException`, …). See [Saloon — handling failures](https://docs.saloon.dev/the-basics/handling-failures).

## Match telemetry

Telemetry files are gzipped JSON on a public CDN, typically 5-15 MB, and are downloaded by a separate connector that carries no API key and does not count against your rate limit.

```php
$match = $bluezone->match()->find('steam', $matchId);

// Parse the file into a Bluezone\Responses\Telemetry DTO (reads it into memory)
$telemetry = $bluezone->telemetry()->fetch($match->assetUrl);
$telemetry = $match->getTelemetry();   // same thing
```

Use `download()` instead when you want the bytes rather than the objects. It returns the compressed body as a PSR-7 `StreamInterface` and decodes nothing:

```php
$stream = $bluezone->telemetry()->download($match->assetUrl);
$out = fopen('/archive/'.$match->id.'.json.gz', 'wb');
while (! $stream->eof()) {
    fwrite($out, $stream->read(1 << 20));
}
fclose($out);
```

## Telemetry events

```php
// Every event as a Bluezone\Telemetry\Events\* object
$events = $telemetry->events();

// The undecoded events, exactly as PUBG wrote them
$raw = $telemetry->raw();

// Events after the first circle
$telemetry->eventsDuringGame();

// Event types this version of Bluezone has no class for, with their counts
$telemetry->unmappedTypes();   // ['LogSomeNewThing' => 12]
```

Events whose `_T` has no class are skipped rather than failing the parse, and counted by `unmappedTypes()`.

### Player events

```php
$player = $telemetry->player($accountId);

$player->all();                             // every event the player appears in
$player->attackEvents();
$player->attackEventsFromVehicle();
$player->causeDamageEvents();
$player->takeDamageEvents();
$player->killEvents();
$player->killEventsFromVehicle();
$player->knockEvents();
$player->knockEventsFromVehicle();
$player->downedEvents();
$player->healEvents();
$player->itemAttachEvents();
$player->itemDetachEvents();
$player->itemDropEvents();
$player->itemEquipEvents();
$player->itemPickupEvents();
$player->itemPickupFromCarePackageEvents();
$player->itemPickupFromCustomPackageEvents();
$player->itemPickupFromLootBoxEvents();
$player->itemUnequipEvents();
$player->itemUseEvents();
$player->objectDestroyEvents();
$player->objectInteractionEvents();
$player->parachuteLandingEvents();
$player->positionEvents();
$player->useThrowableEvents();
$player->swimEvents();
$player->swimStartEvents();
$player->swimEndEvents();
$player->vaultEvents();
$player->vehicleEvents();
$player->weaponFireCountEvents();
$player->wheelDestroyEvents();

// Interactions with one other player, and per-weapon slices
$player->causeDamageToPlayer($otherAccountId);
$player->takeDamageFromPlayer($otherAccountId);
$player->killEventsForWeapon('WeapHK416_C');
$player->causeDamageEventsForWeapon('WeapHK416_C');

// Environment
$player->takeBluezoneDamageEvents();
```

### Match events

```php
$telemetry->match()->definition();       // MatchDefinition
$telemetry->match()->start();            // MatchStart
$telemetry->match()->end();              // MatchEnd
$telemetry->match()->phaseChanges();     // Collection<PhaseChange>
$telemetry->match()->carePackageEvents();
$telemetry->match()->stateEvents();      // Collection<GameStatePeriodic>
```

### Filtering events

`events()` is a [Laravel Collection](https://laravel.com/docs/12.x/collections), so filter it however you like:

```php
use Bluezone\Telemetry\Events\PlayerAttack;
use Bluezone\Telemetry\Events\PlayerPosition;

$attacks = $telemetry->events()->filter(
    fn ($event) => $event instanceof PlayerAttack && $event->attacker->accountId === $accountId
);

// Or drop the noisiest types
$interesting = $telemetry->excludeEvents([PlayerPosition::class]);
```

## Testing

Bluezone is a Saloon connector, so mock it with Saloon's `MockClient`:

```php
use Bluezone\Bluezone;
use Bluezone\Requests\PlayerSearchRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

$bluezone = new Bluezone('test-key');
$bluezone->withMockClient(new MockClient([
    PlayerSearchRequest::class => MockResponse::make(['data' => [/* ... */]]),
]));
```

Telemetry downloads go through a second connector (`TelemetryConnector`), which a `MockClient` attached to the `Bluezone` instance does not reach; use `MockClient::global([...])` to mock them.

This package's own suite replays recorded responses:

```php
MockResponse::fixture('player');   // tests/Fixtures/player.json
```

To re-record a fixture, delete the file and run the recording test with a real key:

```
PUBG_API_KEY=your-key vendor/bin/pest tests/Feature/FixtureRecordingTest.php
```

Run the checks with `composer check` (Pint, PHPStan level 5, Pest).
