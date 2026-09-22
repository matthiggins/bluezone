<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Concerns;

use Illuminate\Support\Collection;

trait HasWeaponEvents
{
    public function killEventsForWeapon(string $weaponCauserName): Collection
    {
        return $this->killEvents()->filter(fn ($e) => isset($e->killerDamageInfo) && $e->killerDamageInfo->causerName == $weaponCauserName);
    }

    public function causeDamageEventsForWeapon(string $weaponCauserName): Collection
    {
        return $this->causeDamageEvents()->filter(fn ($e) => isset($e->damageCauserName) && $e->damageCauserName == $weaponCauserName);
    }
}
