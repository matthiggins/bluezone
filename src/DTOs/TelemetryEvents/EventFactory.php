<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

class EventFactory
{
    /**
     * Create a new Event DTO from the event data
     */
    public static function createDTO(array $data): AbstractEventDTO|array
    {
        switch($data['_T']) {
            case 'LogArmorDestroy':
                return ArmorDestroy::fromEvent($data);
            case 'LogCarePackageLand':
                return CarePackageLand::fromEvent($data);
            case 'LogCarePackageSpawn':
                return CarePackageSpawn::fromEvent($data);
            case 'LogGameStatePeriodic':
                return GameStatePeriodic::fromEvent($data);
            case 'LogHeal':
                return Heal::fromEvent($data);
            case 'LogItemAttach':
                return ItemAttach::fromEvent($data);
            case 'LogItemDetach':
                return ItemDetach::fromEvent($data);
            case 'LogItemDrop':
                return ItemDrop::fromEvent($data);
            case 'LogItemEquip':
                return ItemEquip::fromEvent($data);
            case 'LogItemPickup':
                return ItemPickup::fromEvent($data);
            case 'LogItemPickupFromCarePackage':
                return ItemPickupFromCarePackage::fromEvent($data);
            case 'LogItemPickupFromCustomPackage':
                return ItemPickupFromCustomPackage::fromEvent($data);
            case 'LogItemPickupFromLootBox':
                return ItemPickupFromLootBox::fromEvent($data);
            case 'LogItemUnequip':
                return ItemUnequip::fromEvent($data);
            case 'LogItemUse':
                return ItemUse::fromEvent($data);
            case 'LogMatchDefinition':
                return MatchDefinition::fromEvent($data);
            case 'LogMatchEnd':
                return MatchEnd::fromEvent($data);
            case 'LogMatchStart':
                return MatchStart::fromEvent($data);
            case 'LogObjectDestroy':
                return ObjectDestroy::fromEvent($data);
            case 'LogObjectInteraction':
                return ObjectInteraction::fromEvent($data);
            case 'LogParachuteLanding':
                return ParachuteLanding::fromEvent($data);
            case 'LogPhaseChange':
                return PhaseChange::fromEvent($data);
            case 'LogPlayerAttack':
                return PlayerAttack::fromEvent($data);
            case 'LogPlayerLogin':
                return PlayerLogin::fromEvent($data);
            case 'LogPlayerLogout':
                return PlayerLogout::fromEvent($data);
            case 'LogPlayerCreate':
                return PlayerCreate::fromEvent($data);
            case 'LogPlayerKillV2':
                return PlayerKillV2::fromEvent($data);
            case 'LogPlayerMakeGroggy':
                return PlayerMakeGroggy::fromEvent($data);
            case 'LogPlayerPosition':
                return PlayerPosition::fromEvent($data);
            case 'LogPlayerTakeDamage':
                return PlayerTakeDamage::fromEvent($data);
            case 'LogPlayerUseThrowable':
                return PlayerUseThrowable::fromEvent($data);
            case 'LogSwimEnd':
                return SwimEnd::fromEvent($data);
            case 'LogSwimStart':
                return SwimStart::fromEvent($data);
            case 'LogVaultStart':
                return VaultStart::fromEvent($data);
            case 'LogVehicleRide':
                return VehicleRide::fromEvent($data);
            case 'LogVehicleDamage':
                return VehicleDamage::fromEvent($data);
            case 'LogVehicleDestroy':
                return VehicleDestroy::fromEvent($data);
            case 'LogVehicleLeave':
                return VehicleLeave::fromEvent($data);
            case 'LogWeaponFireCount':
                return WeaponFireCount::fromEvent($data);
            case 'LogWheelDestroy':
                return WheelDestroy::fromEvent($data);
            default:
                return $data;
        }
    }
}
