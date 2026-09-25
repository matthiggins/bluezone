<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Region;
use Bluezone\Responses\Leaderboard;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\HasConnector;

class LeaderboardRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct(
        protected Region $region,
        protected string $seasonId,
        protected GameMode $gameMode,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->region->value.'/leaderboards/'.$this->seasonId.'/'.$this->gameMode->value;
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Leaderboard::make($response, $this->region, $this->gameMode);
    }
}
