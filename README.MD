# BLUEZONE : A PHP SDK for the PUBG API 

BLUEZONE is an SDK for PHP that makes using the [PUBG API](https://developer.pubg.com/) dead simple. It provides a set of simple and intuitive methods that allow you to interact with the PUBG API without having to worry about low-level details such as authentication and request handling. With BLUEZONE, you can easily retrieve data for players, matches, seasons, weapon mastery, and survival mastery. It also includes a set of data transfer objects (DTOs) that help you work with the data returned by the API in a structured and organized way.

In addition to accessing data from the API, BLUEZONE also allows you to access match telemetry files and parse them for player data. This makes it easy to analyze gameplay data and gain insights into player behavior. Whether you're building a tool to help players improve their skills or conducting research on player behavior, BLUEZONE provides a powerful and flexible way to work with PUBG data.

## Installation

To install, require the package `matthiggins/bluezone-php-sdk` via composer.
```
composer require matthiggins/bluezone-php-sdk
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
$request = $bluezone->player()->search($shard, $playerName);

$player = $bluezone->player()->find($shard, $accountId)->dto();
```

## Getting data
You can get the returned data in multiple different formats. Using the response DTOs will format the response data and often provide methods to interact with the data. You can also return the data as JSON or an object. 

**As DTO (recommended)**
```php
$player = $request->dto();       // Return the data transfer object for this request
```

**As JSON**
```php
$json = $request->json();       // Return decoded JSON data from the PUBG API
```

**As object**
```php
$object = $request->object();       // Return data as an object
```

**As Illuminate\Collection**
```php
$object = $request->collect();       // Return data as a Collection
```

## Checking request responses
You can access details about the request including helper methods for successes and failures. 

```php
$request->successful();     // true if the response status is in the 200s
$request->ok();             // true if the response status is 200
$request->serverError();    // true if the response status is 500
$request->clientError();    // true if the response status is in the 400s
$request->failed();         // true if the response status is not 200
```

Dealing with errors by defining a callback on the `onError` method.
```php
use Saloon\Contracts\Response;

$request->onError(function(Response $response) {
    // Handle error logic
});
```

## Available methods

```php
$seasons = $bluezone->season()->all($shard)->dto();
$player = $bluezone->player()->find($shard, $accountId)->dto();
$player = $bluezone->player()->search($shard, 'TGLTN')->dto();
$seasonStats = $bluezone->player()->seasonStats($shard, $season, $accountId)->dto();
$seasonStats = $bluezone->player()->seasonStatsMany($shard, $season, 'solo-fpp', [$accountId,$accountId])->dto();
$rankedSeasonStats = $bluezone->player()->rankedSeasonStats($shard, $season, $accountId)->dto();
$lifetimeStats = $bluezone->player()->lifetimeStats($shard, $accountId)->dto();
$lifetimeStats = $bluezone->player()->lifetimeStatsMany($shard, 'solo-fpp', [$accountId,$accountId])->dto();
$results = $bluezone->player()->searchMany($shard, ['TGLTN', 'hwinn'])->dto();
$match = $bluezone->match()->find($shard, $matchId)->dto();
$weaponMastery = $bluezone->mastery()->weapon($shard, $accountId)->dto();
$survivalMastery = $bluezone->mastery()->survival($shard, $accountId)->dto();
```

## Working with Match Telemetry Data
The PUBG API provides access to very detailed match data in a Match Telemetry file. This file contains information about game details, player movement, player action, zone information, and more. Telemetry files are large JSON files that can be parsed and analyzed for deeper analysis. 

To get a telemetry file you must first request details of a PUBG match. 

```php
$match = $bluezone->match()->find($shard, $matchId)->dto();
$telemetry = $match->getTelemetry();

$data = $telemetry->data();      // Telemetry data mapped to Event DTOs and Object DTOs
$playerEvents = $telemetry->getEventsForPlayer($accountId);     // Get telemetry events for a specific player
$positionEvents = $telemetry->getPositionEventsForPlayer($accountId);     // Get position events for a specific player
$killEvents = $telemetry->getKillEventsForPlayer($accountId);     // Get position events for a specific player
```

You can easily filter out events from the data using [Laravel Collection](https://laravel.com/docs/10.x/collections) methods. 