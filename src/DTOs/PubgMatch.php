<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs;

use Carbon\Carbon;
use LaravelPubg\DTOs\Concerns\AccessesJsonDictionaries;
use LaravelPubg\Requests\Telemetry\TelemetryRequest;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Contracts\Response;
use Saloon\Traits\Responses\HasResponse;

class PubgMatch implements WithResponse
{
    use AccessesJsonDictionaries;
    use HasResponse;

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
        readonly public array $stats,
        readonly public array $teams,
    ) {
        $this->mapName = $this->getValueFromJsonFile('telemetry/mapName.json', $this->mapName);
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json()['data'];
        $included = $response->json()['included'];

        return self::fromArray($data, $included);
    }

    public static function fromArray(array $data, array $included): self
    {
        $statsArray = collect($included)
            ->filter(fn ($item) => $item['type'] === 'participant' && $item['attributes']['stats'] !== null)
            ->mapWithKeys(fn ($item) => [$item['id'] => $item['attributes']['stats']])
            ->sortBy('winPlace')
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
            stats: $statsArray,
            teams: $teamsArray,
        );
    }

    /**
     * Request the telemetry from the PUBG API
     */
    public function getTelemetry(): Telemetry
    {
        $response = (new TelemetryRequest($this->assetUrl))->send();

        return $response->dto();
    }
}
