<?php

declare(strict_types=1);

namespace Bluezone\DTOs\Concerns;

trait HasWeaponEvents
{
    /**
     * Player kill events for a specific weapon
     */
    public function killEventsForWeapon(string $weaponCauserName): \Illuminate\Support\Collection
    {
        return $this->killEvents()->filter(fn ($e) => isset($e->killerDamageInfo) && $e->killerDamageInfo->causerName == $weaponCauserName);
    }

    /**
     * Player cause damage events for a specific weapon
     */
    public function causeDamageEventsForWeapon(string $weaponCauserName): \Illuminate\Support\Collection
    {
        return $this->causeDamageEvents()->filter(fn ($e) => isset($e->damageCauserName) && $e->damageCauserName == $weaponCauserName);
    }
}
