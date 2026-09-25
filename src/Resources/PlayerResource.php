<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Shard;
use Bluezone\Exceptions\PlayerNotFoundException;
use Bluezone\Requests\LifetimeStatsManyRequest;
use Bluezone\Requests\LifetimeStatsRequest;
use Bluezone\Requests\PlayerAccountManyRequest;
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
    public function find(Shard|string $shard, string $accountId): Player
    {
        $shard = Shard::resolve($shard);

        try {
            return $this->send(new PlayerAccountRequest(shard: $shard, accountId: $accountId), Player::class);
        } catch (NotFoundException) {
            throw PlayerNotFoundException::forAccountId($shard, $accountId);
        }
    }

    /** Up to 10 players in one request; an id the shard does not know is left out of the collection. */
    public function findMany(Shard|string $shard, array $accountIds): PlayerCollection
    {
        $shard = Shard::resolve($shard);

        try {
            $players = $this->sendNullable(new PlayerAccountManyRequest(shard: $shard, accountIds: $accountIds), PlayerCollection::class);
        } catch (NotFoundException) {
            throw PlayerNotFoundException::forAccountId($shard, implode(',', $accountIds));
        }

        return $players ?? throw PlayerNotFoundException::forAccountId($shard, implode(',', $accountIds));
    }

    public function recentMatches(Player $player, int $limit = 20): Collection
    {
        return $player->recentMatches($this->connector, $limit);
    }

    public function recentCasualMatches(Player $player, int $limit = 20): Collection
    {
        return $this->recentMatches(
            player: $player,
            limit: $limit,
        )->filter(fn ($match) => ! $match->isRanked());
    }

    public function recentRankedMatches(Player $player, int $limit = 20): Collection
    {
        return $this->recentMatches(
            player: $player,
            limit: $limit,
        )->filter(fn ($match) => $match->isRanked());
    }

    public function search(Shard|string $shard, string $playerName): Player
    {
        $shard = Shard::resolve($shard);

        try {
            $player = $this->sendNullable(new PlayerSearchRequest(shard: $shard, playerName: $playerName), Player::class);
        } catch (NotFoundException) {
            throw PlayerNotFoundException::forName($shard, $playerName);
        }

        return $player ?? throw PlayerNotFoundException::forName($shard, $playerName);
    }

    public function searchMany(Shard|string $shard, array $playerNames): PlayerCollection
    {
        $shard = Shard::resolve($shard);

        try {
            $players = $this->sendNullable(new PlayerSearchManyRequest(shard: $shard, playerNames: $playerNames), PlayerCollection::class);
        } catch (NotFoundException) {
            throw PlayerNotFoundException::forName($shard, implode(',', $playerNames));
        }

        return $players ?? throw PlayerNotFoundException::forName($shard, implode(',', $playerNames));
    }

    public function seasonStats(Shard|string $shard, string $seasonId, string $accountId): SeasonStats
    {
        return $this->send(new SeasonStatsRequest(
            shard: Shard::resolve($shard),
            seasonId: $seasonId,
            accountId: $accountId,
        ), SeasonStats::class);
    }

    public function seasonStatsMany(Shard|string $shard, string $seasonId, GameMode|string $gameMode, array $accountIds): SeasonStatsCollection
    {
        return $this->send(new SeasonStatsManyRequest(
            shard: Shard::resolve($shard),
            seasonId: $seasonId,
            gameMode: GameMode::resolve($gameMode),
            accountIds: $accountIds,
        ), SeasonStatsCollection::class);
    }

    public function rankedSeasonStats(Shard|string $shard, string $seasonId, string $accountId): RankedSeasonStats
    {
        return $this->send(new RankedSeasonStatsRequest(
            shard: Shard::resolve($shard),
            seasonId: $seasonId,
            accountId: $accountId,
        ), RankedSeasonStats::class);
    }

    /** One request per account id: the PUBG API has no batch ranked endpoint. */
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

    public function lifetimeStats(Shard|string $shard, string $accountId): LifetimeStats
    {
        return $this->send(new LifetimeStatsRequest(
            shard: Shard::resolve($shard),
            accountId: $accountId,
        ), LifetimeStats::class);
    }

    public function lifetimeStatsMany(Shard|string $shard, GameMode|string $gameMode, array $playerIds): LifetimeStatsCollection
    {
        return $this->send(new LifetimeStatsManyRequest(
            shard: Shard::resolve($shard),
            gameMode: GameMode::resolve($gameMode),
            playerIds: $playerIds,
        ), LifetimeStatsCollection::class);
    }

    public function weaponMastery(Shard|string $shard, string $accountId): WeaponMastery
    {
        return $this->send(new WeaponMasteryRequest(
            shard: Shard::resolve($shard),
            accountId: $accountId,
        ), WeaponMastery::class);
    }

    public function survivalMastery(Shard|string $shard, string $accountId): SurvivalMastery
    {
        return $this->send(new SurvivalMasteryRequest(
            shard: Shard::resolve($shard),
            accountId: $accountId,
        ), SurvivalMastery::class);
    }
}
