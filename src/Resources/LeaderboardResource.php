<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Region;
use Bluezone\Exceptions\LeaderboardNotFoundException;
use Bluezone\Requests\LeaderboardRequest;
use Bluezone\Responses\Leaderboard;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class LeaderboardResource extends Resource
{
    public function get(Region|string $region, string $seasonId, GameMode|string $gameMode): Leaderboard
    {
        $region = Region::resolve($region);
        $gameMode = GameMode::resolve($gameMode);

        try {
            return $this->send(new LeaderboardRequest(region: $region, seasonId: $seasonId, gameMode: $gameMode), Leaderboard::class);
        } catch (NotFoundException) {
            throw LeaderboardNotFoundException::forBoard($region, $seasonId, $gameMode);
        }
    }
}
