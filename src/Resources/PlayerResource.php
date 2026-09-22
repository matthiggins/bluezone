<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Requests\LifetimeStatsManyRequest;
use Bluezone\Requests\LifetimeStatsRequest;
use Bluezone\Requests\PlayerAccountRequest;
use Bluezone\Requests\PlayerSearchManyRequest;
use Bluezone\Requests\PlayerSearchRequest;
use Bluezone\Requests\RankedSeasonStatsRequest;
use Bluezone\Requests\SeasonStatsManyRequest;
use Bluezone\Requests\SeasonStatsRequest;
use Bluezone\Requests\SurvivalMasteryRequest;
use Bluezone\Requests\WeaponMasteryRequest;
use Bluezone\Responses\LifetimeStats;
use Bluezone\Responses\LifetimeStatsCollection;
use Bluezone\Responses\Player;
use Bluezone\Responses\PlayerCollection;
use Bluezone\Responses\RankedSeasonStats;
use Bluezone\Responses\RankedSeasonStatsCollection;
use Bluezone\Responses\SeasonStats;
use Bluezone\Responses\SeasonStatsCollection;
use Bluezone\Responses\SurvivalMastery;
use Bluezone\Responses\WeaponMastery;
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
     */
    public function recentMatches(Player $player, int $limit = 20): Collection
    {
        return $player->recentMatches($this->connector, $limit);
    }

    /**
     * Get recent casual matches for a player
     */
    public function recentCasualMatches(Player $player, int $limit = 20): Collection
    {
        return $this->recentMatches(
            player: $player,
            limit: $limit,
        )->filter(fn ($match) => ! $match->isRanked());
    }

    /**
     * Get recent ranked matches for a player
     */
    public function recentRankedMatches(Player $player, int $limit = 20): Collection
    {
        return $this->recentMatches(
            player: $player,
            limit: $limit,
        )->filter(fn ($match) => $match->isRanked());
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
    public function seasonStatsMany(string $shard, string $seasonId, string $gameMode, array $accountIds): SeasonStatsCollection
    {
        return $this->send(new SeasonStatsManyRequest(
            shard: $shard,
            seasonId: $seasonId,
            gameMode: $gameMode,
            accountIds: $accountIds,
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
     * Get ranked season stats for many players. The PUBG API
     * does not support getting multiple ranked season stats
     * in a single request... because of that we are cycling
     * through the account ids and making a request for each
     */
    public function rankedSeasonStatsMany(string $shard, string $seasonId, array $accountIds): RankedSeasonStatsCollection
    {
        $statsResponseCollection = collect($accountIds)->map(function ($id) use ($shard, $seasonId) {
            return $this->rankedSeasonStats(
                shard: $shard,
                seasonId: $seasonId,
                accountId: $id,
            );
        });

        return new RankedSeasonStatsCollection($statsResponseCollection);
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
