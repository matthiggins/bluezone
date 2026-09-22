<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Concerns;

use Illuminate\Support\Collection;

trait HasPlayerInteractionEvents
{
    /**
     * Cause damage events for a given player account ID
     */
    public function causeDamageToPlayer(string $accountId): Collection
    {
        return $this->causeDamageEvents()->filter(fn ($e) => $e->victim->accountId === $accountId);
    }

    /**
     * Take damage events for a given player account ID
     */
    public function takeDamageFromPlayer(string $accountId): Collection
    {
        return $this->takeDamageEvents()->filter(fn ($e) => isset($e->attacker) && $e->attacker->accountId === $accountId);
    }
}
