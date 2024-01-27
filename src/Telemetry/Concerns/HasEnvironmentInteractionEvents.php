<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Concerns;

trait HasEnvironmentInteractionEvents
{
    /**
     * Player take bluezone damage events
     */
    public function takeBluezoneDamageEvents(): \Illuminate\Support\Collection
    {
        return $this->takeDamageEvents()->filter(fn ($e) => ! isset($e->attacker) && $e->damageTypeCategory == 'Damage_BlueZone');
    }
}
