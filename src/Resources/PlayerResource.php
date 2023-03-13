<?php

namespace PubgApi\Resources;

use PubgApi\Requests\Players\PlayerAccountRequest;
use PubgApi\Requests\Players\PlayerSearchManyRequest;
use PubgApi\Requests\Players\PlayerSearchRequest;
use PubgApi\Requests\Stats\LifetimeStatsManyRequest;
use PubgApi\Requests\Stats\LifetimeStatsRequest;
use PubgApi\Requests\Stats\RankedSeasonStatsRequest;
use PubgApi\Requests\Stats\SeasonStatsManyRequest;
use PubgApi\Requests\Stats\SeasonStatsRequest;
use Saloon\Http\Response;

class PlayerResource extends Resource
{
    /**
     * Find a player by account id
     */
    public function find(string $shard, string $accountId): Response
    {
        return $this->connector->send(new PlayerAccountRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }

    /**
     * Get lifetime stats for a player
     */
    public function lifetimeStats(string $shard, string $accountId): Response
    {
        return $this->connector->send(new LifetimeStatsRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }

    /**
     * Get lifetime stats for multiple players
     */
    public function lifetimeStatsMany(string $shard, string $gameMode, array $playerIds): Response
    {
        return $this->connector->send(new LifetimeStatsManyRequest(
            shard: $shard,
            gameMode: $gameMode,
            playerIds: $playerIds,
        ));
    }

    /**
     * Get ranked season stats for a player
     */
    public function rankedSeasonStats(string $shard, string $seasonId, string $accountId): Response
    {
        return $this->connector->send(new RankedSeasonStatsRequest(
            shard: $shard,
            seasonId: $seasonId,
            accountId: $accountId,
        ));
    }

    /**
     * Search for a player by name
     */
    public function search(string $shard, string $playerName): Response
    {
        return $this->connector->send(new PlayerSearchRequest(
            shard: $shard,
            playerName: $playerName,
        ));
    }

    /**
     * Search for multiple players by name
     */
    public function searchMany(string $shard, array $playerNames): Response
    {
        return $this->connector->send(new PlayerSearchManyRequest(
            shard: $shard,
            playerNames: $playerNames,
        ));
    }

    /**
     * Get season stats for a player
     */
    public function seasonStats(string $shard, string $seasonId, string $accountId): Response
    {
        return $this->connector->send(new SeasonStatsRequest(
            shard: $shard,
            seasonId: $seasonId,
            accountId: $accountId,
        ));
    }

    /**
     * Get season stats for multiple players
     */
    public function seasonStatsMany(string $shard, string $seasonId, string $gameMode, array $playerIds): Response
    {
        return $this->connector->send(new SeasonStatsManyRequest(
            shard: $shard,
            seasonId: $seasonId,
            gameMode: $gameMode,
            playerIds: $playerIds,
        ));
    }
}
