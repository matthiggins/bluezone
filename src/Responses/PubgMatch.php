<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Resources\TelemetryResource;
use Bluezone\Support\Dictionary;
use Bluezone\TelemetryConnector;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Saloon\Http\Response;

class PubgMatch extends PubgResponse
{
    /**
     * @param  Collection<string, PlayerMatchStats>  $stats
     * @param  Collection<int, MatchRoster>  $rosters
     */
    public function __construct(
        public readonly string $id,
        public readonly string $shard,
        public readonly string $assetId,
        public readonly string $assetUrl,
        public readonly Carbon $createdAt,
        public readonly int $duration,
        public readonly string $gameMode,
        public readonly string $mapName,
        public readonly string $matchType,
        public readonly string $seasonState,
        public readonly bool $isCustomMatch,
        public readonly Collection $stats,
        public readonly Collection $rosters,
    ) {}

    /**
     * Create a DTO from a response.
     */
    public static function make(Response $response): self
    {
        $data = $response->json()['data'];
        $included = $response->json()['included'];

        return self::fromArray($data, $included);
    }

    /**
     * Create a DTO from an array.
     *
     * @param  array<string, mixed>  $data
     * @param  array<int, array<string, mixed>>  $included  "included" data from the PUBG API to get stats and rosters
     */
    public static function fromArray(array $data, array $included): self
    {
        $stats = collect($included)
            ->filter(fn ($item) => $item['type'] === 'participant' && $item['attributes']['stats'] !== null)
            ->mapWithKeys(fn ($item) => [$item['id'] => $item['attributes']['stats']])
            ->sortBy('winPlace')
            ->map(fn ($item) => PlayerMatchStats::fromArray($item));

        $asset = collect($included)
            ->where('type', 'asset')
            ->first();

        return new static(
            id: $data['id'],
            shard: $data['attributes']['shardId'],
            assetId: $asset['id'],
            assetUrl: $asset['attributes']['URL'],
            createdAt: Carbon::parse($data['attributes']['createdAt']),
            duration: $data['attributes']['duration'],
            gameMode: $data['attributes']['gameMode'],
            mapName: Dictionary::get('telemetry/mapName.json', $data['attributes']['mapName']),
            matchType: $data['attributes']['matchType'],
            seasonState: $data['attributes']['seasonState'],
            isCustomMatch: (bool) ($data['attributes']['isCustomMatch'] ?? false),
            stats: $stats,
            rosters: collect($included)->where('type', 'roster')->map(MatchRoster::fromArray(...))->sortBy('rank')->values(),
        );
    }

    /**
     * Get the telemetry DTO from the telemetry file for this match.
     */
    public function getTelemetry(): Telemetry
    {
        return (new TelemetryResource(new TelemetryConnector))->fetch($this->assetUrl);
    }

    /**
     * Get the stats for a player.
     */
    public function statsForPlayer(string $playerId): PlayerMatchStats
    {
        return collect($this->stats)
            ->where('playerId', $playerId)
            ->first();
    }

    /**
     * Get the roster a player fought on.
     */
    public function rosterForPlayer(string $accountId): ?MatchRoster
    {
        $participantId = $this->stats->search(fn (PlayerMatchStats $s) => $s->playerId === $accountId);

        return $participantId === false ? null : $this->rosters->first(fn (MatchRoster $r) => in_array($participantId, $r->participantIds, true));
    }

    /**
     * Get the stats of everyone on a player's roster except the player.
     *
     * @return Collection<int, PlayerMatchStats>
     */
    public function teammatesOf(string $accountId): Collection
    {
        $roster = $this->rosterForPlayer($accountId);

        return $roster === null ? collect() : collect($roster->participantIds)
            ->map(fn (string $id) => $this->stats[$id] ?? null)
            ->filter(fn (?PlayerMatchStats $s) => $s !== null && $s->playerId !== $accountId)
            ->values();
    }

    /**
     * Is this a ranked match?
     */
    public function isRanked(): bool
    {
        return $this->matchType === 'competitive';
    }

    /**
     * Get the percent of players that are bots.
     */
    public function botPercent(): float
    {
        $botCount = $this->totalBots();

        return $botCount ? floatval(number_format(($botCount / $this->totalPlayers()) * 100, 2)) : floatval($botCount);
    }

    /**
     * Get the total number of bots in the roster
     */
    public function totalBots(): int
    {
        return $this->stats->filter(fn ($stat) => str_starts_with($stat->playerId, 'ai.'))->count();
    }

    /**
     * Get the total number of players in the roster
     */
    public function totalPlayers(): int
    {
        return $this->stats->count();
    }

    /**
     * Get the total number of teams in the match
     */
    public function totalTeams(): int
    {
        return $this->rosters->count();
    }
}
