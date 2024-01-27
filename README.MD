![bluezone-banner](https://github.com/matthiggins/bluezone/assets/422780/e309788b-b3bd-47fb-9df3-edaa2d3f6a52)

# BLUEZONE : A PHP SDK for the PUBG API 

[![Version](http://poser.pugx.org/matthiggins/bluezone/version)](https://packagist.org/packages/matthiggins/bluezone)
[![PHP Version Require](http://poser.pugx.org/matthiggins/bluezone/require/php)](https://packagist.org/packages/matthiggins/bluezone)
[![License](http://poser.pugx.org/matthiggins/bluezone/license)](https://packagist.org/packages/matthiggins/bluezone)

BLUEZONE is an SDK for PHP that makes using the [PUBG API](https://developer.pubg.com/) dead simple. It provides a set of simple and intuitive methods that allow you to interact with the PUBG API without having to worry about low-level details such as authentication and request handling. With BLUEZONE, you can easily retrieve data for players, matches, seasons, weapon mastery, and survival mastery. It also includes a set of data transfer objects (DTOs) that help you work with the data returned by the API in a structured and organized way.

In addition to accessing data from the API, BLUEZONE also allows you to access match telemetry files and parse them for player data. This makes it easy to analyze gameplay data and gain insights into player behavior. Whether you're building a tool to help players improve their skills or conducting research on player behavior, BLUEZONE provides a powerful and flexible way to work with PUBG data.

---

**Relevant Links**
- [PUBG API](https://developer.pubg.com/)
- [Saloon](https://docs.saloon.dev/)
- [Laravel Collections](https://laravel.com/docs/10.x/collections)

---

## Table of Contents
- [BLUEZONE : A PHP SDK for the PUBG API](#bluezone--a-php-sdk-for-the-pubg-api)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Making requests](#making-requests)
  - [Available methods](#available-methods)
    - [Seasons list](#seasons-list)
    - [Player search, player profiles, and stats](#player-search-player-profiles-and-stats)
    - [Matches](#matches)
  - [Accessing Match Telemetry Data](#accessing-match-telemetry-data)
    - [Working with telemetry events](#working-with-telemetry-events)
    - [Game events and match events from telemetry](#game-events-and-match-events-from-telemetry)
    - [Filter events from the telemetry data](#filter-events-from-the-telemetry-data)

---

## Installation

To install, require the package `matthiggins/bluezone` via composer.
```
composer require matthiggins/bluezone
```

## Usage

Instantiate a new Bluezone instance using your PUBG API key. You can get your own API key by going to the [PUBG Developer Portal](https://developer.pubg.com/).

Bluezone uses [Saloon](https://docs.saloon.dev/) to create a Connector, Requests, and DTOs for the PUBG API. You can use all of the features of Saloon in the requests and responses.

```php
use Bluezone\Bluezone;

$bluezone = new Bluezone($apiKey);
```

## Making requests

Requests will return a PUBG DTO instance or a collection of instances. 

```php
// Search for a player
$player = $bluezone->player()->search($shard, $playerName);

// Find a player by account ID
$player = $bluezone->player()->find($shard, $accountId);

```

If the request results in an error an exception will be thrown. 

```php

use Saloon\Exceptions\SaloonException;

try {
    $seasons = $bluezone->season()->all('fail');
}catch(SaloonException $e) {
    $status = $e->getStatus();
}

```

By default, Saloon provides classes for specific errors related to the request.

[Saloon - Handling Failures](https://docs.saloon.dev/the-basics/handling-failures)

```
SaloonException
├── FatalRequestException (Connection Errors)
└── RequestException (Request Errors)
    ├── ServerException (5xx)
    │   ├── InternalServerErrorException (500)
    │   ├── ServiceUnavailableException (503)
    │   └── GatewayTimeoutException (504)
    └── ClientException (4xx)
        ├── UnauthorizedException (401)
        ├── ForbiddenException (403)
        ├── NotFoundException (404)
        ├── MethodNotAllowedException (405)
        ├── RequestTimeOutException (408)
        ├── UnprocessableEntityException (422)
        └── TooManyRequestsException (429)
```

## Available methods

Bluezone has easy methods for accessing the [PUBG API endpoints](https://documentation.pubg.com/en/introduction.ht


### Seasons list
```php
// Get all PUBG seasons
$seasons = $bluezone->season()->all($shard);
```

### Player search, player profiles, and stats

You can search for a player by their in-game name and shard or you can retrieve a player using their Account ID. 

```php

// Find a specific player using the account id
$player = $bluezone->player()->find($shard, $accountId);

// Search for a player by name 
// NOTE : player search requires the name to be entered exactly as it is displayed in-game
$player = $bluezone->player()->search($shard, $playerName);

// Search for up to 10 players
$results = $bluezone->player()->searchMany($shard, [$playerName01, $playerName02]);

// Season stats for a single player
$seasonStats = $bluezone->player()->seasonStats($shard, $season, $accountId);

// Season stats for up to 10 players
$seasonStats = $bluezone->player()->seasonStatsMany($shard, $season, $gameMode, [$accountId,$accountId]);

// Ranked season stats for a single player
$rankedSeasonStats = $bluezone->player()->rankedSeasonStats($shard, $season, $accountId);

// Lifetime season stats for a single player
$lifetimeStats = $bluezone->player()->lifetimeStats($shard, $accountId);

// Lifetime stats for up to 10 players
$lifetimeStats = $bluezone->player()->lifetimeStatsMany($shard, $gameMode, [$accountId,$accountId]);

// Get weapon mastery for a single player
$weaponMastery = $bluezone->player()->weaponMastery($shard, $accountId);

// Get survival mastery for a single player
$survivalMastery = $bluezone->player()->survivalMastery($shard, $accountId);
```

### Matches
```php
// Get a match
$match = $bluezone->match()->find($shard, $matchId);
```

---

## Accessing Match Telemetry Data
The PUBG API provides access to very detailed match data in a Match Telemetry file. This file contains information about game details, player movement, player action, zone information, and more. Telemetry files are large JSON files that can be parsed and analyzed for deeper analysis. 

To get a telemetry file you must first request details of a PUBG match. 

```php
// Get a single match DTO instance
$match = $bluezone->match()->find($shard, $matchId);

// Get the telemetry DTO instance
$telemetry = $match->getTelemetry();

// Get the raw telemetry events in a Collection
$rawEvents = $telemetry->raw();

// Alternatively you can map all telemetry 
// events to their DTO instances
$events = $telemetry->events();   

```

### Working with telemetry events
The telemetry file is essentially a huge list of events that happen during a match. These are events for individual players as well as game events like care packages, circle movement, etc. You can easily filter these events with helper methods that make pulling player and game data easier.

```php
// Get all telemetry events for a specific player
$telemetry->player($accountId)->all();

// Get all attack events for a specific player
$telemetry->player($accountId)->attackEvents();

// Get all heal events for a specific player
$telemetry->player($accountId)->healEvents();

// Get all item attachment events for a specific player
$telemetry->player($accountId)->itemAttachEvents();

// Get all item detachment events for a specific player
$telemetry->player($accountId)->itemDetachEvents();

// Get all item drop events for a specific player
$telemetry->player($accountId)->itemDropEvents();

// Get all item equip events for a specific player
$telemetry->player($accountId)->itemEquipEvents();

// Get all item pickup events for a specific player
$telemetry->player($accountId)->itemPickupEvents();

// Get all item unequip events for a specific player
$telemetry->player($accountId)->itemUnequipEvents();

// Get all item use events for a specific player
$telemetry->player($accountId)->itemUseEvents();

// Get all kill events for a specific player
$telemetry->player($accountId)->killEvents();

// Get all object destroy events for a specific player
$telemetry->player($accountId)->objectDestroyEvents();

// Get all object interaction events for a specific player
$telemetry->player($accountId)->objectInteractionEvents();

// Get all parachute landing events for a specific player
$telemetry->player($accountId)->parachuteLandingEvents();

// Get all position events for a specific player
$telemetry->player($accountId)->positionEvents();

// Get all take damage events for a specific player
$telemetry->player($accountId)->takeDamageEvents();

// Get all throwable use events for a specific player
$telemetry->player($accountId)->useThrowableEvents();

// Get all swim events for a specific player
$telemetry->player($accountId)->swimEvents();

// Get all swim start events for a specific player
$telemetry->player($accountId)->swimStartEvents();

// Get all swim end events for a specific player
$telemetry->player($accountId)->swimEndEvents();

// Get all vault events for a specific player
$telemetry->player($accountId)->vaultEvents();

// Get all vehicle events for a specific player
$telemetry->player($accountId)->vehicleEvents();

// Get all weapon fire count events for a specific player
$telemetry->player($accountId)->weaponFireCountEvents();

// Get all wheel destroy events for a specific player
$telemetry->player($accountId)->wheelDestroyEvents();
```

### Game events and match events from telemetry
In addition to player events you can also easily access game events and match details.

```php
// Get all care package events from the telemetry
$telemetry->match()->carePackageEvents();

// Get the definition of the match
$telemetry->match()->definition();

// Get the end state of the match
$telemetry->match()->end();

// Get all phase change events for the match
$telemetry->match()->phaseChanges();

// Get the start state of the match
$telemetry->match()->start();

// Get all state events from the match
$telemetry->match()->stateEvents();
```

### Filter events from the telemetry data

You can easily filter out events from the data using [Laravel Collection](https://laravel.com/docs/10.x/collections) methods. 

For example:

```php
use Bluezone\Telemetry\Events\PlayerAttack;

$playerAttackEvents = $telemetry->events()->filter(function ($event) use ($accountId) {
    return ($event instanceof PlayerAttack) && $event->attacker->accountId == $accountId;
});
```
