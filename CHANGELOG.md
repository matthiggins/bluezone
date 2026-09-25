# Changelog

## v1.2.0 — 2026-09-25

### Added

- `player()->findMany($shard, $accountIds)` returns a `PlayerCollection` for up to 10 account ids in one request (`filter[playerIds]`); a 404 or empty result throws `PlayerNotFoundException`.
- `PlayerMatchStats::$shardId`, the participant's own platform. A `console` match mixes `xbox` and `psn` players, so the match's shard no longer stands for everyone in it.

## v1.1.0 — 2026-09-25

### Added

- `Bluezone::sample()->get($shard, ?$since)` returns `Samples`: a shard's random sample of recent match ids. `$since` is sent as UTC, and one more than 14 days back or in the future throws `InvalidSampleWindowException` before any request.
- `Bluezone::leaderboard()->get($region, $seasonId, $gameMode)` returns `Leaderboard`, with `LeaderboardPlayer` rows sorted by rank. A 404 throws `LeaderboardNotFoundException`.
- `Bluezone\Enums\Region`, the platform-region shards the leaderboard endpoint takes.

## v1.0.1 — 2026-09-25

### Fixed

- `MatchRequest` no longer spends or waits on the rate limit budget; PUBG does not rate limit the match endpoint.

## v1.0.0 — 2026-09-24

### Breaking

- PHP ^8.3 and Saloon ^4. `Saloon\Contracts\*` types are gone.
- `Bluezone::__construct(string $apiKey, ?RateLimitStore $store = null, int $requestsPerMinute = 10)`.
- Resource methods take `Shard|string` and `GameMode|string`; requests take the enums.
- `SeasonStats`, `LifetimeStats`, `RankedSeasonStats`, `WeaponMastery` and `SurvivalMastery` expose typed DTOs instead of raw arrays; `LifetimeStats::$matches` uses kebab keys (`solo-fpp`).
- `SeasonStats::$bestRankPoint` is a float; `RankedGameModeStats` no longer synthesises a `losses` value.
- `PlayerMatchStats::$timeSurvived` is a float, and `PlayerMatchStats::fromArray()` casts and defaults every field.
- `PubgMatch::$teams` is replaced by `PubgMatch::$rosters` (`MatchRoster`) with a boolean `won`; `PubgMatch::$mapName` is readonly.
- `Status::fromArray()` is removed; `Status` is built from the response and gains nullable `releasedAt` and `version`.
- `StatusResource::get()` returns `Status` and `SeasonResource::all()` returns `Seasons` instead of the `PubgResponse` base; the protected `Resource::send()` now takes the expected DTO class.
- `EventFactory::make()` returns `?TelemetryEvent`; unmapped event types are skipped and counted by `Telemetry::unmappedTypes()`.
- `TelemetryRequest` is removed; use `Bluezone::telemetry()->download()` / `fetch()`.
- `MatchNotFoundException`'s constructor is replaced by `MatchNotFoundException::forId()`; `ItemNotFoundException` is removed.
- `PlayerDestroyBreachableWall::$weapon` is `Item|string`.
- `PubgMatch::statsForPlayer()` returns `?PlayerMatchStats`; it already returned null for an account that did not play the match.
- `WeaponHitDetails::$damage` and `$dBNODamage` are floats, matching `WeaponStats`.
- Response, telemetry event and telemetry object classes are `final`; `TelemetryEvent` is abstract and declares `public readonly Common $common`.
- The test suite runs with `failOnWarning` and `failOnNotice`.

### Added

- Client-side rate limiting through the Saloon rate limit plugin, with 429 detection and a configurable store; connect and request timeouts.
- `Shard` and `GameMode` enums with `label()`, `isConsole()`, `isFpp()`, `teamSize()` and `battleRoyale()`.
- `BluezoneException` base with `PlayerNotFoundException`, `MatchNotFoundException`, `InvalidTelemetryUrlException` and `InvalidTelemetryException`.
- `TelemetryConnector` and `Bluezone::telemetry()`, with a streamed gzip `download()` and an in-memory `fetch()`.
- Typed `GameModeStats`, `RankTier`, `RankedGameModeStats`, `WeaponSummary`, `WeaponStatsTotal`, `WeaponMedal`, `SurvivalStat` and `MatchRoster`, plus `forMode()` on season, lifetime and ranked stats.
- `RedZoneEnded`, `BlackZoneEnded`, `PlayerDestroyBreachableWall` and `SpecialZoneInCharacters` events.
- `PlayerMatchStats::$dBNOs`, `Status::$releasedAt` / `$version`, `SurvivalMastery::$tier`.
- `Bluezone\Support\Dictionary` with a static cache, and `bin/sample-telemetry.php`.
- Fixture-based test suite and GitHub Actions CI.

### Fixed

- `RankedSeasonStatsCollection::make()` passed arrays into a method expecting a `Response`.
- `VehicleDestroy` and `ItemPickupFromCustomPackage` did not read their `common` block.
- `PhaseChange` phase names; dictionary files are read once per process instead of per object.
- Player names are sent as encoded query parameters instead of being concatenated into the url.
- `Telemetry::events()` returns a copy, so a caller cannot mutate the memoised collection.
- Telemetry urls keep their query string.
- `player()->search()` and `searchMany()` throw `PlayerNotFoundException` for an empty `data` array instead of raising a `TypeError`.
- Every scalar telemetry value is cast at the call site, so a JSON float in an int-typed field no longer throws.
