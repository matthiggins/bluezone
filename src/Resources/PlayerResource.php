<?php

namespace Bluezone\Resources;

use Bluezone\DTOs\LifetimeStats;
use Bluezone\DTOs\LifetimeStatsCollection;
use Bluezone\DTOs\Player;
use Bluezone\DTOs\PlayerCollection;
use Bluezone\DTOs\RankedSeasonStats;
use Bluezone\DTOs\SeasonStats;
use Bluezone\DTOs\SeasonStatsCollection;
use Bluezone\DTOs\SurvivalMastery;
use Bluezone\DTOs\WeaponMastery;
use Bluezone\Requests\Mastery\SurvivalMasteryRequest;
use Bluezone\Requests\Mastery\WeaponMasteryRequest;
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
    public function find(string $shard, string $accountId): Player
    {
        return $this->send(new PlayerAccountRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }

    /**
     * Get recent matches for a player
     *
     * @param Player $player
     * @param integer $limit
     * @return Collection
     */
    public function recentMatches(Player $player, int $limit = 20): Collection
    {
        return $player->recentMatches($this->connector, $limit);
    }

    /**
     * Get recent casual matches for a player
     *
     * @param Player $player
     * @param integer $limit
     * @return Collection
     */
    public function recentCasualMatches(Player $player, int $limit = 20): Collection
    {
        return $this->recentMatches(
            player: $player,
            limit: $limit,
        )->filter(fn($match) => ! $match->isRanked());
    }

    /**
     * Get recent ranked matches for a player
     *
     * @param Player $player
     * @param integer $limit
     * @return Collection
     */
    public function recentRankedMatches(Player $player, int $limit = 20): Collection
    {
        return $this->recentMatches(
            player: $player,
            limit: $limit,
        )->filter(fn($match) => $match->isRanked());
    }

    /**
     * Get lifetime stats for a player
     */
    public function lifetimeStats(string $shard, string $accountId): LifetimeStats
    {
        return $this->send(new LifetimeStatsRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }

    /**
     * Get lifetime stats for multiple players
     */
    public function lifetimeStatsMany(string $shard, string $gameMode, array $playerIds): LifetimeStatsCollection
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
    public function rankedSeasonStats(string $shard, string $seasonId, string $accountId): RankedSeasonStats
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
    public function search(string $shard, string $playerName): Player
    {
        return $this->send(new PlayerSearchRequest(
            shard: $shard,
            playerName: $playerName,
        ));
    }

    /**
     * Search for multiple players by name
     */
    public function searchMany(string $shard, array $playerNames): PlayerCollection
    {
        return $this->send(new PlayerSearchManyRequest(
            shard: $shard,
            playerNames: $playerNames,
        ));
    }

    /**
     * Get season stats for a player
     */
    public function seasonStats(string $shard, string $seasonId, string $accountId): SeasonStats
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
    public function seasonStatsMany(string $shard, string $seasonId, string $gameMode, array $playerIds): SeasonStatsCollection
    {
        return $this->send(new SeasonStatsManyRequest(
            shard: $shard,
            seasonId: $seasonId,
            gameMode: $gameMode,
            playerIds: $playerIds,
        ));
    }

    /**
     * Get all weapon mastery for a player
     */
    public function weaponMastery(string $shard, string $accountId): WeaponMastery
    {
        return $this->send(new WeaponMasteryRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }

    /**
     * Get all survival mastery for a player
     */
    public function survivalMastery(string $shard, string $accountId): SurvivalMastery
    {
        return $this->send(new SurvivalMasteryRequest(
            shard: $shard,
            accountId: $accountId,
        ));
    }
}
