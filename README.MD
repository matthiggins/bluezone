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
  - [Checking request responses](#checking-request-responses)
  - [Available methods](#available-methods)
    - [Seasons](#seasons)
    - [Players](#players)
    - [Matches](#matches)
  - [JSON data from the PUBG API request](#json-data-from-the-pubg-api-request)
  - [Working with Match Telemetry Data](#working-with-match-telemetry-data)
    - [Get player events from telemetry data](#get-player-events-from-telemetry-data)
    - [Get match events from the telemetry data](#get-match-events-from-the-telemetry-data)
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

By default, requests will return a DTO instance or a Collection of DTO instances. You can also get the raw data from the PUBG API by using the `->json()` method on your DTO result. 

```php
// Search for a player
$player = $bluezone->player()->search($shard, $playerName);

// Find a player by account ID
$player = $bluezone->player()->find($shard, $accountId);

// Return decoded JSON data from the PUBG API
$raw = $player->json(); 

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

## Checking request responses
You can access details about the request including helper methods for successes and failures. 

```php

$player = $bluezone->player()->search($shard, $playerName);

$player->getResponse()->successful();     // true if the response status is in the 200s
$player->getResponse()->ok();             // true if the response status is 200
$player->getResponse()->serverError();    // true if the response status is 500
$player->getResponse()->clientError();    // true if the response status is in the 400s
$player->getResponse()->failed();         // true if the response status is not 200
```

## Available methods

Bluezone has easy methods for accessing the [PUBG API endpoints](https://documentation.pubg.com/en/introduction.ht


### Seasons
```php
// Get all PUBG seasons
$seasons = $bluezone->season()->all($shard);
```

### Players
```php

// Find a specific player 
$player = $bluezone->player()->find($shard, $accountId);

// Search for a player by name 
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

## JSON data from the PUBG API request

You can still access the underlying data returned from PUBG by calling the `json()` method on your response. 

```php
$seasons = $bluezone->season()->all($shard);
$seasons->json();
```

---

## Working with Match Telemetry Data
The PUBG API provides access to very detailed match data in a Match Telemetry file. This file contains information about game details, player movement, player action, zone information, and more. Telemetry files are large JSON files that can be parsed and analyzed for deeper analysis. 

To get a telemetry file you must first request details of a PUBG match. 

```php
$match = $bluezone->match()->find($shard, $matchId)->dto();
$telemetry = $match->getTelemetry();    // Returns a Telemetry DTO

// All telemetry events mapped to DTOs
$events = $telemetry->events();   
```

### Get player events from telemetry data

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

### Get match events from the telemetry data

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
use Bluezone\DTOs\TelemetryEvents\PlayerAttack;

$playerAttackEvents = $telemetry->events()->filter(function ($event) use ($accountId) {
    return ($event instanceof PlayerAttack) && $event->attacker->accountId == $accountId;
});
```
