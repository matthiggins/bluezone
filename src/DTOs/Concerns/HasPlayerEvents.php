<?php

declare(strict_types=1);

namespace PubgApi\DTOs\Concerns;

use PubgApi\DTOs\TelemetryEvents\PlayerKillV2;
use PubgApi\DTOs\TelemetryEvents\PlayerPosition;

trait HasPlayerEvents
{
    /**
     * Get a list of events for a specific player
     */
    public function getEventsForPlayer(string $accountId): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) use ($accountId) {
            return (isset($event->character) && $event->character->accountId == $accountId) ||
            (isset($event->victim) && $event->victim->accountId == $accountId) ||
            (isset($event->attacker) && $event->attacker->accountId == $accountId);
            (isset($event->finisher) && $event->finisher->accountId == $accountId);
            (isset($event->killer) && $event->killer->accountId == $accountId);
            (isset($event->dBNOMaker) && $event->dBNOMaker->accountId == $accountId);
        })->values();
    }

    /**
     * Get a list of events for a specific player
     */
    public function getPositionEventsForPlayer(string $accountId): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) use ($accountId) {
            return ($event instanceof PlayerPosition) && $event->character->accountId == $accountId;
        })->values();
    }

    /**
     * Get a list of events for a specific player
     */
    public function getKillEventsForPlayer(string $accountId): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) use ($accountId) {
            return ($event instanceof PlayerKillV2) &&
                ($event->killer && $event->killer->accountId == $accountId);
        })->values();
    }
}
