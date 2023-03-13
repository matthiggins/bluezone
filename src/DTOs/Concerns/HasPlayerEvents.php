<?php

declare(strict_types=1);

namespace Bluezone\DTOs\Concerns;

use Bluezone\DTOs\TelemetryEvents\Heal;
use Bluezone\DTOs\TelemetryEvents\ItemAttach;
use Bluezone\DTOs\TelemetryEvents\ItemDetach;
use Bluezone\DTOs\TelemetryEvents\ItemDrop;
use Bluezone\DTOs\TelemetryEvents\ItemEquip;
use Bluezone\DTOs\TelemetryEvents\ItemPickup;
use Bluezone\DTOs\TelemetryEvents\ItemPickupFromCarePackage;
use Bluezone\DTOs\TelemetryEvents\ItemPickupFromCustomPackage;
use Bluezone\DTOs\TelemetryEvents\ItemPickupFromLootBox;
use Bluezone\DTOs\TelemetryEvents\ItemUnequip;
use Bluezone\DTOs\TelemetryEvents\ItemUse;
use Bluezone\DTOs\TelemetryEvents\ObjectDestroy;
use Bluezone\DTOs\TelemetryEvents\ObjectInteraction;
use Bluezone\DTOs\TelemetryEvents\ParachuteLanding;
use Bluezone\DTOs\TelemetryEvents\PlayerAttack;
use Bluezone\DTOs\TelemetryEvents\PlayerKillV2;
use Bluezone\DTOs\TelemetryEvents\PlayerPosition;
use Bluezone\DTOs\TelemetryEvents\PlayerTakeDamage;
use Bluezone\DTOs\TelemetryEvents\PlayerUseThrowable;
use Bluezone\DTOs\TelemetryEvents\SwimEnd;
use Bluezone\DTOs\TelemetryEvents\SwimStart;
use Bluezone\DTOs\TelemetryEvents\VaultStart;
use Bluezone\DTOs\TelemetryEvents\VehicleLeave;
use Bluezone\DTOs\TelemetryEvents\VehicleRide;
use Bluezone\DTOs\TelemetryEvents\WeaponFireCount;
use Bluezone\DTOs\TelemetryEvents\WheelDestroy;

trait HasPlayerEvents
{
    /**
     * Get a list of events for a specific player
     */
    public function all(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return (isset($event->character) && $event->character->accountId == $this->accountId) ||
            (isset($event->victim) && $event->victim->accountId == $this->accountId) ||
            (isset($event->attacker) && $event->attacker->accountId == $this->accountId);
            (isset($event->finisher) && $event->finisher->accountId == $this->accountId);
            (isset($event->killer) && $event->killer->accountId == $this->accountId);
            (isset($event->dBNOMaker) && $event->dBNOMaker->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of attack events for a specific player
     */
    public function attackEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerAttack) &&
                ($event->attacker && $event->attacker->accountId == $this->accountId);
        })->values();
    }


    /**
     * Get a list of heal events for a specific player
     */
    public function healEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof Heal) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item attach events for a specific player
     */
    public function itemAttachEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemAttach) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item detach events for a specific player
     */
    public function itemDetachEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemDetach) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item drop events for a specific player
     */
    public function itemDropEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemDrop) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item equip events for a specific player
     */
    public function itemEquipEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemEquip) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item pickup events for a specific player
     */
    public function itemPickupEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemPickup) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item pickup from care package events for a specific player
     */
    public function itemPickupFromCarePackageEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemPickupFromCarePackage) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item pickup from care package events for a specific player
     */
    public function itemPickupFromCustomPackageEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemPickupFromCustomPackage) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item pickup from care package events for a specific player
     */
    public function itemPickupFromLootBoxEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemPickupFromLootBox) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item unequip events for a specific player
     */
    public function itemUnequipEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemUnequip) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of item use events for a specific player
     */
    public function itemUseEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ItemUse) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of kill events for a specific player
     */
    public function killEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerKillV2) &&
                ($event->killer && $event->killer->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of object destroy events for a specific player
     */
    public function objectDestroyEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ObjectDestroy) &&
                ($event->character && $event->character->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of object interaction events for a specific player
     */
    public function objectInteractionEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ObjectInteraction) &&
                ($event->character && $event->character->accountId == $this->accountId);
        })->values();
    }

    /**
     * Get a list of parachute events for a specific player
     */
    public function parachuteLandingEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof ParachuteLanding) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of position events for a specific player
     */
    public function positionEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerPosition) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of take damage events for a specific player
     */
    public function takeDamageEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerTakeDamage) && $event->victim->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of use throwable events for a specific player
     */
    public function useThrowableEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof PlayerUseThrowable) && $event->attacker->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of swim events for a specific player
     */
    public function swimEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return (($event instanceof SwimStart) || ($event instanceof SwimEnd)) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of swim end events for a specific player
     */
    public function swimEndEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof SwimEnd) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of swim start events for a specific player
     */
    public function swimStartEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof SwimStart) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of vault start events for a specific player
     */
    public function vaultEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof VaultStart) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of vehicle events for a specific player
     */
    public function vehicleEvents(): \Illuminate\Support\Collection
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
    public function weaponFireCountEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof WeaponFireCount) && $event->character->accountId == $this->accountId;
        })->values();
    }

    /**
     * Get a list of wheel destroy events for a specific player
     */
    public function wheelDestroyEvents(): \Illuminate\Support\Collection
    {
        return $this->telemetry->filter(function ($event) {
            return ($event instanceof WheelDestroy) && $event->attacker->accountId == $this->accountId;
        })->values();
    }
}
