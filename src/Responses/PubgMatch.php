<?php

declare(strict_types=1);

namespace Bluezone\Responses;

use Bluezone\Requests\TelemetryRequest;
use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Telemetry;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;

class PubgMatch extends PubgResponse
{
    use AccessesJsonDictionaries;

    public function __construct(
        readonly public string $id,
        readonly public string $shard,
        readonly public string $assetId,
        readonly public string $assetUrl,
        readonly public Carbon $createdAt,
        readonly public int $duration,
        readonly public string $gameMode,
        public string $mapName,
        readonly public string $matchType,
        readonly public string $seasonState,
        readonly public Collection $stats,
        readonly public Collection $teams,
    ) {
        $this->mapName = $this->getValueFromJsonFile('telemetry/mapName.json', $this->mapName);
    }

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
     * @param array $data
     * @param array $included "included" data from the PUBG API to get stats and teams
     */
    public static function fromArray(array $data, array $included): self
    {
        $statsArray = collect($included)
            ->filter(fn ($item) => $item['type'] === 'participant' && $item['attributes']['stats'] !== null)
            ->mapWithKeys(fn ($item) => [$item['id'] => $item['attributes']['stats']])
            ->sortBy('winPlace')
            ->map(fn ($item) => PlayerMatchStats::fromArray($item))
            ->toArray();

        $asset = collect($included)
            ->where('type', 'asset')
            ->first();

        $teamsArray = collect($included)
            ->filter(fn ($item) => $item['type'] === 'roster')
            ->map(function ($item) use ($statsArray) {
                return [
                    'id' => $item['attributes']['stats']['teamId'],
                    'rank' => $item['attributes']['stats']['rank'],
                    'won' => $item['attributes']['won'],
                    'shardId' => $item['attributes']['shardId'],
                    'members' => collect($item['relationships']['participants']['data'])
                        ->map(function ($item) use ($statsArray) {
                            return [
                                'id' => $item['id'],
                                'player' => $statsArray[$item['id']],
                            ];
                        })
                        ->toArray(),
                ];
            })
            ->sortBy('rank')
            ->values()
            ->toArray();

        return new static(
            id: $data['id'],
            shard: $data['attributes']['shardId'],
            assetId: $asset['id'],
            assetUrl: $asset['attributes']['URL'],
            createdAt: Carbon::parse($data['attributes']['createdAt']),
            duration: $data['attributes']['duration'],
            gameMode: $data['attributes']['gameMode'],
            mapName: $data['attributes']['mapName'],
            matchType: $data['attributes']['matchType'],
            seasonState: $data['attributes']['seasonState'],
            stats: collect($statsArray),
            teams: collect($teamsArray),
        );
    }

    /**
     * Get the telemetry DTO from the telemetry file for this match.
     * 
     * @return Telemetry
     */
    public function getTelemetry(): Telemetry
    {
        $response = (new TelemetryRequest($this->assetUrl))->send();

        return $response->dto();
    }

    /**
     * Get the stats for a player.
     * 
     * @param string $playerId
     * @return PlayerMatchStats
     */
    public function statsForPlayer(string $playerId): PlayerMatchStats
    {
        return collect($this->stats)
            ->where('playerId', $playerId)
            ->first();
    }

    /**
     * Is this a ranked match?
     *
     * @return boolean
     */
    public function isRanked(): bool
    {
        return $this->matchType === 'competitive';
    }

    /**
     * Get the percent of players that are bots.
     *
     * @return float
     */
    public function botPercent(): float
    {
        $botCount = $this->totalBots();
        return $botCount ? floatval(number_format(($botCount / $this->totalPlayers()) * 100, 2)) : floatval($botCount);
    }

    /**
     * Get the total number of bots in the roster
     *
     * @return integer
     */
    public function totalBots(): int
    {
        return $this->stats->filter(fn ($stat) => str_starts_with($stat->playerId, 'ai.'))->count();
    }

    /**
     * Get the total number of players in the roster
     *
     * @return integer
     */
    public function totalPlayers(): int
    {
        return $this->stats->count();
    }

    /**
     * Get the total number of teams in the roster
     *
     * @return integer
     */
    public function totalTeams(): int
    {
        return $this->teams->count();
    }
}
