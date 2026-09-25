<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Region;
use Bluezone\Requests\LeaderboardRequest;
use Bluezone\Responses\Leaderboard;

class LeaderboardResource extends Resource
{
    public function get(Region|string $region, string $seasonId, GameMode|string $gameMode, int $page = 0): Leaderboard
    {
        return $this->send(new LeaderboardRequest(
            region: Region::resolve($region),
            seasonId: $seasonId,
            gameMode: GameMode::resolve($gameMode),
            page: $page,
        ), Leaderboard::class);
    }
}
