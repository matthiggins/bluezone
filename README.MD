# BLUEZONE : A PHP SDK for the PUBG API 

BLUEZONE is an SDK for PHP that makes using the [PUBG API](https://developer.pubg.com/) dead simple. It provides a set of simple and intuitive methods that allow you to interact with the PUBG API without having to worry about low-level details such as authentication and request handling. With BLUEZONE, you can easily retrieve data for players, matches, seasons, weapon mastery, and survival mastery. It also includes a set of data transfer objects (DTOs) that help you work with the data returned by the API in a structured and organized way.

In addition to accessing data from the API, BLUEZONE also allows you to access match telemetry files and parse them for player data. This makes it easy to analyze gameplay data and gain insights into player behavior. Whether you're building a tool to help players improve their skills or conducting research on player behavior, BLUEZONE provides a powerful and flexible way to work with PUBG data.

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

```php
// Return a Player DTO instance from the search response
$player = $bluezone->player()->search($shard, $playerName);

// Return a Player DTO instance from the player id response
$player = $bluezone->player()->find($shard, $accountId);
```

## Getting data
By default, requests will return a DTO instance or a Collection of DTO instances. You can also get the raw data from the PUBG API by using the `->json()` method on your DTO result. 

```php

$array = $response->json();           // Return decoded JSON data from the PUBG API

```

## Checking request responses
You can access details about the request including helper methods for successes and failures. 

```php
$response->getResponse()->successful();     // true if the response status is in the 200s
$response->getResponse()->ok();             // true if the response status is 200
$response->getResponse()->serverError();    // true if the response status is 500
$response->getResponse()->clientError();    // true if the response status is in the 400s
$response->getResponse()->failed();         // true if the response status is not 200
```

## Available methods

Bluezone has easy methods for accessing the [PUBG API endpoints](https://documentation.pubg.com/en/introduction.ht

```php

// Get all PUBG seasons
$seasons = $bluezone->season()->all($shard);

// Find a specific player 
$player = $bluezone->player()->find($shard, $accountId);

// Search for a player by name 
$player = $bluezone->player()->search($shard, 'TGLTN');

// Search for up to 10 players at once
$results = $bluezone->player()->searchMany($shard, ['TGLTN', 'hwinn']);

// Season stats for a single player
$seasonStats = $bluezone->player()->seasonStats($shard, $season, $accountId);

// Season stats for multiple players
$seasonStats = $bluezone->player()->seasonStatsMany($shard, $season, 'solo-fpp', [$accountId,$accountId]);

// Ranked season stats for a single player
$rankedSeasonStats = $bluezone->player()->rankedSeasonStats($shard, $season, $accountId);

// Lifetime season stats for a single player
$lifetimeStats = $bluezone->player()->lifetimeStats($shard, $accountId);

// Lifetime stats for a multiple players
$lifetimeStats = $bluezone->player()->lifetimeStatsMany($shard, 'solo-fpp', [$accountId,$accountId]);

// Get a single match
$match = $bluezone->match()->find($shard, $matchId);

// Get weapon mastery for a single player
$weaponMastery = $bluezone->mastery()->weapon($shard, $accountId);

// Get survival mastery for a single player
$survivalMastery = $bluezone->mastery()->survival($shard, $accountId);

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

$data = $telemetry->data();      // Telemetry data mapped to Telemetry Event instances
$playerEvents = $telemetry->getEventsForPlayer($accountId);     // Get telemetry events for a specific player
$positionEvents = $telemetry->getPositionEventsForPlayer($accountId);     // Get position events for a specific player
$killEvents = $telemetry->getKillEventsForPlayer($accountId);     // Get position events for a specific player
```

You can easily filter out events from the data using [Laravel Collection](https://laravel.com/docs/10.x/collections) methods. 

For example:
```php
use Bluezone\DTOs\TelemetryEvents\PlayerAttack;

$playerAttackEvents = $telemetry->data()->filter(function ($event) use ($accountId) {
    return ($event instanceof PlayerAttack) && $event->attacker->accountId == $accountId;
});
```