<?php

declare(strict_types=1);

namespace Bluezone\Exceptions;

use Bluezone\Enums\Shard;

final class MatchNotFoundException extends BluezoneException
{
    private function __construct(public readonly Shard $shard, public readonly string $matchId)
    {
        parent::__construct("Match [{$matchId}] is not available on shard [{$shard->value}]; PUBG keeps matches for about 14 days.", 404);
    }

    public static function forId(Shard $shard, string $matchId): self
    {
        return new self($shard, $matchId);
    }
}
