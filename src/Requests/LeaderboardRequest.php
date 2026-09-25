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
        protected int $page = 0,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'shards/'.$this->region->value.'/leaderboards/'.$this->seasonId.'/'.$this->gameMode->value;
    }

    /** @return array<string, int> */
    protected function defaultQuery(): array
    {
        return ['page[number]' => $this->page];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Leaderboard::make($response);
    }
}
