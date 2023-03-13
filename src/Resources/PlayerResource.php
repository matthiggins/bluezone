<?php

namespace Bluezone\Resources;

use Bluezone\DTOs\PubgDTO;
use Bluezone\Requests\Players\PlayerAccountRequest;
use Bluezone\Requests\Players\PlayerSearchManyRequest;
use Bluezone\Requests\Players\PlayerSearchRequest;
use Bluezone\Requests\Stats\LifetimeStatsManyRequest;
use Bluezone\Requests\Stats\LifetimeStatsRequest;
use Bluezone\Requests\Stats\RankedSeasonStatsRequest;
use Bluezone\Requests\Stats\SeasonStatsManyRequest;
use Bluezone\Requests\Stats\SeasonStatsRequest;
use Illuminate\Support\Collection;

class PlayerResource extends Resource
{
    /**
     * Find a player by account id
     */
    public function find(string $shard, string $accountId): PubgDTO
    {
        return $this->send(new PlayerAccountRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }

    /**
     * Get lifetime stats for a player
     */
    public function lifetimeStats(string $shard, string $accountId): PubgDTO
    {
        return $this->send(new LifetimeStatsRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }

    /**
     * Get lifetime stats for multiple players
     */
    public function lifetimeStatsMany(string $shard, string $gameMode, array $playerIds): Collection
    {
        return $this->send(new LifetimeStatsManyRequest(
            shard: $shard,
            gameMode: $gameMode,
            playerIds: $playerIds,
        ));
    }

    /**
     * Get ranked season stats for a player
     */
    public function rankedSeasonStats(string $shard, string $seasonId, string $accountId): PubgDTO
    {
        return $this->send(new RankedSeasonStatsRequest(
            shard: $shard,
            seasonId: $seasonId,
            accountId: $accountId,
        ));
    }

    /**
     * Search for a player by name
     */
    public function search(string $shard, string $playerName): PubgDTO
    {
        return $this->send(new PlayerSearchRequest(
            shard: $shard,
            playerName: $playerName,
        ));
    }

    /**
     * Search for multiple players by name
     */
    public function searchMany(string $shard, array $playerNames): Collection
    {
        return $this->send(new PlayerSearchManyRequest(
            shard: $shard,
            playerNames: $playerNames,
        ));
    }

    /**
     * Get season stats for a player
     */
    public function seasonStats(string $shard, string $seasonId, string $accountId): PubgDTO
    {
        return $this->send(new SeasonStatsRequest(
            shard: $shard,
            seasonId: $seasonId,
            accountId: $accountId,
        ));
    }

    /**
     * Get season stats for multiple players
     */
    public function seasonStatsMany(string $shard, string $seasonId, string $gameMode, array $playerIds): Collection
    {
        return $this->send(new SeasonStatsManyRequest(
            shard: $shard,
            seasonId: $seasonId,
            gameMode: $gameMode,
            playerIds: $playerIds,
        ));
    }
}
