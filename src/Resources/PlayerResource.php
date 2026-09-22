<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Shard;
use Bluezone\Exceptions\PlayerNotFoundException;
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
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class PlayerResource extends Resource
{
    /**
     * Find a player by account id
     */
    public function find(Shard|string $shard, string $accountId): Player
    {
        $shard = Shard::resolve($shard);

        try {
            return $this->send(new PlayerAccountRequest(shard: $shard, accountId: $accountId));
        } catch (NotFoundException) {
            throw PlayerNotFoundException::forAccountId($shard, $accountId);
        }
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
    public function search(Shard|string $shard, string $playerName): Player
    {
        $shard = Shard::resolve($shard);

        try {
            return $this->send(new PlayerSearchRequest(shard: $shard, playerName: $playerName));
        } catch (NotFoundException) {
            throw PlayerNotFoundException::forName($shard, $playerName);
        }
    }

    /**
     * Search for multiple players by name
     */
    public function searchMany(Shard|string $shard, array $playerNames): PlayerCollection
    {
        $shard = Shard::resolve($shard);

        try {
            return $this->send(new PlayerSearchManyRequest(shard: $shard, playerNames: $playerNames));
        } catch (NotFoundException) {
            throw PlayerNotFoundException::forName($shard, implode(',', $playerNames));
        }
    }

    /**
     * Get season stats for a player
     */
    public function seasonStats(Shard|string $shard, string $seasonId, string $accountId): SeasonStats
    {
        return $this->send(new SeasonStatsRequest(
            shard: Shard::resolve($shard),
            seasonId: $seasonId,
            accountId: $accountId,
        ));
    }

    /**
     * Get season stats for multiple players
     */
    public function seasonStatsMany(Shard|string $shard, string $seasonId, GameMode|string $gameMode, array $accountIds): SeasonStatsCollection
    {
        return $this->send(new SeasonStatsManyRequest(
            shard: Shard::resolve($shard),
            seasonId: $seasonId,
            gameMode: GameMode::resolve($gameMode),
            accountIds: $accountIds,
        ));
    }

    /**
     * Get ranked season stats for a player
     */
    public function rankedSeasonStats(Shard|string $shard, string $seasonId, string $accountId): RankedSeasonStats
    {
        return $this->send(new RankedSeasonStatsRequest(
            shard: Shard::resolve($shard),
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
    public function rankedSeasonStatsMany(Shard|string $shard, string $seasonId, array $accountIds): RankedSeasonStatsCollection
    {
        $shard = Shard::resolve($shard);

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
    public function lifetimeStats(Shard|string $shard, string $accountId): LifetimeStats
    {
        return $this->send(new LifetimeStatsRequest(
            shard: Shard::resolve($shard),
            accountId: $accountId,
        ));
    }

    /**
     * Get lifetime stats for multiple players
     */
    public function lifetimeStatsMany(Shard|string $shard, GameMode|string $gameMode, array $playerIds): LifetimeStatsCollection
    {
        return $this->send(new LifetimeStatsManyRequest(
            shard: Shard::resolve($shard),
            gameMode: GameMode::resolve($gameMode),
            playerIds: $playerIds,
        ));
    }

    /**
     * Get all weapon mastery for a player
     */
    public function weaponMastery(Shard|string $shard, string $accountId): WeaponMastery
    {
        return $this->send(new WeaponMasteryRequest(
            shard: Shard::resolve($shard),
            accountId: $accountId,
        ));
    }

    /**
     * Get all survival mastery for a player
     */
    public function survivalMastery(Shard|string $shard, string $accountId): SurvivalMastery
    {
        return $this->send(new SurvivalMasteryRequest(
            shard: Shard::resolve($shard),
            accountId: $accountId,
        ));
    }
}
