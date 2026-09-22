<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Concerns;

use Illuminate\Support\Collection;

trait HasEnvironmentInteractionEvents
{
    public function takeBluezoneDamageEvents(): Collection
    {
        return $this->takeDamageEvents()->filter(fn ($e) => ! isset($e->attacker) && $e->damageTypeCategory == 'Damage_BlueZone');
    }
}
