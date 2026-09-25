<?php

declare(strict_types=1);

namespace Bluezone\Exceptions;

use Bluezone\Enums\GameMode;
use Bluezone\Enums\Region;

final class LeaderboardNotFoundException extends BluezoneException
{
    private function __construct(
        public readonly Region $region,
        public readonly string $seasonId,
        public readonly GameMode $gameMode,
    ) {
        parent::__construct("No [{$gameMode->value}] leaderboard for season [{$seasonId}] on region [{$region->value}].", 404);
    }

    public static function forBoard(Region $region, string $seasonId, GameMode $gameMode): self
    {
        return new self($region, $seasonId, $gameMode);
    }
}
