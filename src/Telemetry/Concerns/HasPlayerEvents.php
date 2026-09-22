<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Concerns;

use Bluezone\Telemetry\Events\Heal;
use Bluezone\Telemetry\Events\ItemAttach;
use Bluezone\Telemetry\Events\ItemDetach;
use Bluezone\Telemetry\Events\ItemDrop;
use Bluezone\Telemetry\Events\ItemEquip;
use Bluezone\Telemetry\Events\ItemPickup;
use Bluezone\Telemetry\Events\ItemPickupFromCarePackage;
use Bluezone\Telemetry\Events\ItemPickupFromCustomPackage;
use Bluezone\Telemetry\Events\ItemPickupFromLootBox;
use Bluezone\Telemetry\Events\ItemUnequip;
use Bluezone\Telemetry\Events\ItemUse;
use Bluezone\Telemetry\Events\ObjectDestroy;
use Bluezone\Telemetry\Events\ObjectInteraction;
use Bluezone\Telemetry\Events\ParachuteLanding;
use Bluezone\Telemetry\Events\PlayerAttack;
use Bluezone\Telemetry\Events\PlayerKillV2;
use Bluezone\Telemetry\Events\PlayerMakeGroggy;
use Bluezone\Telemetry\Events\PlayerPosition;
use Bluezone\Telemetry\Events\PlayerTakeDamage;
use Bluezone\Telemetry\Events\PlayerUseThrowable;
use Bluezone\Telemetry\Events\SwimEnd;
use Bluezone\Telemetry\Events\SwimStart;
use Bluezone\Telemetry\Events\VaultStart;
use Bluezone\Telemetry\Events\VehicleLeave;
use Bluezone\Telemetry\Events\VehicleRide;
use Bluezone\Telemetry\Events\WeaponFireCount;
use Bluezone\Telemetry\Events\WheelDestroy;
use Illuminate\Support\Collection;

trait HasPlayerEvents
{
    /**
     * Get a list of events for a specific player
     * These are events where the character was involved
     */
    public function all(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return (isset($event->character) && $event->character->accountId == $this->accountId) ||
            (isset($event->victim) && $event->victim->accountId == $this->accountId) ||
            (isset($event->attacker) && $event->attacker->accountId == $this->accountId) ||
            (isset($event->finisher) && $event->finisher->accountId == $this->accountId) ||
            (isset($event->killer) && $event->killer->accountId == $this->accountId) ||
            (isset($event->dBNOMaker) && $event->dBNOMaker->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of attack events for a specific player
     */
    public function attackEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerAttack) &&
                ($event->attacker && $event->attacker->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of attack events that happened from a vehicle for a specific player
     */
    public function attackEventsFromVehicle(): Collection
    {
        return $this->attackEvents()->filter(fn ($e) => $e->vehicle != null)->values();
    }

    /**
     * Get a list of events where the player caused damage
     */
    public function causeDamageEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerTakeDamage) &&
                ($event->attacker && $event->attacker->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of downed events for a specific player
     */
    public function downedEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerMakeGroggy) &&
                ($event->victim && $event->victim->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of heal events for a specific player
     */
    public function healEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof Heal) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item attach events for a specific player
     */
    public function itemAttachEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemAttach) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item detach events for a specific player
     */
    public function itemDetachEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemDetach) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item drop events for a specific player
     */
    public function itemDropEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemDrop) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item equip events for a specific player
     */
    public function itemEquipEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemEquip) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item pickup events for a specific player
     */
    public function itemPickupEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemPickup) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item pickup from care package events for a specific player
     */
    public function itemPickupFromCarePackageEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemPickupFromCarePackage) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item pickup from care package events for a specific player
     */
    public function itemPickupFromCustomPackageEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemPickupFromCustomPackage) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item pickup from care package events for a specific player
     */
    public function itemPickupFromLootBoxEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemPickupFromLootBox) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item unequip events for a specific player
     */
    public function itemUnequipEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemUnequip) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item use events for a specific player
     */
    public function itemUseEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemUse) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of kill events for a specific player
     */
    public function killEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerKillV2) &&
                ($event->killer && $event->killer->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of attack events that happened from a vehicle for a specific player
     */
    public function killEventsFromVehicle(): Collection
    {
        $attacksFromVehicle = $this->attackEvents()->filter(fn ($e) => $e->vehicle != null)->pluck('attackId');

        return $this->killEvents()->filter(fn ($e) => $attacksFromVehicle->contains($e->attackId))->values();
    }

    /**
     * Get a list of knock events for a specific player
     */
    public function knockEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerMakeGroggy) &&
                ($event->attacker && $event->attacker->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of knock events from a vehicle for a specific player
     */
    public function knockEventsFromVehicle(): Collection
    {
        $attacksFromVehicle = $this->attackEvents()->filter(fn ($e) => $e->vehicle != null)->pluck('attackId');

        return $this->knockEvents()->filter(fn ($e) => $attacksFromVehicle->contains($e->attackId))->values();
    }

    /**
     * Get a list of object destroy events for a specific player
     */
    public function objectDestroyEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ObjectDestroy) &&
                ($event->character && $event->character->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of object interaction events for a specific player
     */
    public function objectInteractionEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ObjectInteraction) &&
                ($event->character && $event->character->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of parachute events for a specific player
     */
    public function parachuteLandingEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ParachuteLanding) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of position events for a specific player
     */
    public function positionEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerPosition) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of take damage events for a specific player
     */
    public function takeDamageEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerTakeDamage) && $event->victim->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of use throwable events for a specific player
     */
    public function useThrowableEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerUseThrowable) && $event->attacker->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of swim events for a specific player
     */
    public function swimEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return (($event instanceof SwimStart) || ($event instanceof SwimEnd)) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of swim end events for a specific player
     */
    public function swimEndEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof SwimEnd) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of swim start events for a specific player
     */
    public function swimStartEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof SwimStart) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of vault start events for a specific player
     */
    public function vaultEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof VaultStart) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of vehicle events for a specific player
     */
    public function vehicleEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return (
                ($event instanceof VehicleRide) ||
                ($event instanceof VehicleLeave)
            ) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of weapon fire count events for a specific player
     */
    public function weaponFireCountEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof WeaponFireCount) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of wheel destroy events for a specific player
     */
    public function wheelDestroyEvents(): Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof WheelDestroy) && $event->attacker->accountId == $this->accountId;
        })->values();
    }
}
