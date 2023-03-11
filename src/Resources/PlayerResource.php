<?php

namespace PubgApi\Resources;

use PubgApi\Requests\Players\MultiplePlayerSearchRequest;
use PubgApi\Requests\Players\PlayerAccountRequest;
use PubgApi\Requests\Players\PlayerSearchRequest;
use PubgApi\Requests\Stats\LifetimeStatsRequest;
use PubgApi\Requests\Stats\MultipleLifetimeStatsRequest;
use PubgApi\Requests\Stats\MultipleSeasonStatsRequest;
use PubgApi\Requests\Stats\RankedSeasonStatsRequest;
use PubgApi\Requests\Stats\SeasonStatsRequest;
use Saloon\Http\Response;

class PlayerResource extends Resource
{
    /**
     * Find a player by account id
     */
    public function find(string $shard, string $accountId): Response
    {
        return $this->connector->send(new PlayerAccountRequest($shard, $accountId));
    }

    /**
     * Get lifetime stats for a player
     */
    public function lifetimeStats(string $shard, string $accountId): Response
    {
        return $this->connector->send(new LifetimeStatsRequest($shard, $accountId));
    }

    /**
     * Get lifetime stats for multiple players
     */
    public function multipleLifetimeStats(string $shard, string $gameMode, array $playerIds): Response
    {
        return $this->connector->send(new MultipleLifetimeStatsRequest($shard, $gameMode, $playerIds));
    }

    /**
     * Get season stats for multiple players
     */
    public function multipleSeasonStats(string $shard, string $seasonId, string $gameMode, array $playerIds): Response
    {
        return $this->connector->send(new MultipleSeasonStatsRequest($shard, $seasonId, $gameMode, $playerIds));
    }

    /**
     * Get ranked season stats for a player
     */
    public function rankedSeason(string $shard, string $seasonId, string $accountId): Response
    {
        return $this->connector->send(new RankedSeasonStatsRequest($shard, $seasonId, $accountId));
    }

    /**
     * Search for a player by name
     */
    public function search(string $shard, string $playerName): Response
    {
        return $this->connector->send(new PlayerSearchRequest($shard, $playerName));
    }

    /**
     * Search for multiple players by name
     */
    public function searchMultiple(string $shard, array $playerNames): Response
    {
        return $this->connector->send(new MultiplePlayerSearchRequest($shard, $playerNames));
    }

    /**
     * Get season stats for a player
     */
    public function seasonStats(string $shard, string $seasonId, string $accountId): Response
    {
        return $this->connector->send(new SeasonStatsRequest($shard, $seasonId, $accountId));
    }
}
