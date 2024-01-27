<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

class EventFactory
{
    /**
     * Create a new Telemetry Event from the event data
     */
    public static function make(array $data): TelemetryEvent|array
    {
        switch($data['_T']) {
            case 'LogArmorDestroy':
                return ArmorDestroy::make($data)->setDate($data['_D']);
            case 'LogCarePackageLand':
                return CarePackageLand::make($data)->setDate($data['_D']);
            case 'LogCarePackageSpawn':
                return CarePackageSpawn::make($data)->setDate($data['_D']);
            case 'LogCharacterCarry':
                return CharacterCarry::make($data)->setDate($data['_D']);
            case 'LogEmPickupLiftOff':
                return EmPickupLiftOff::make($data)->setDate($data['_D']);
            case 'LogGameStatePeriodic':
                return GameStatePeriodic::make($data)->setDate($data['_D']);
            case 'LogHeal':
                return Heal::make($data)->setDate($data['_D']);
            case 'LogItemAttach':
                return ItemAttach::make($data)->setDate($data['_D']);
            case 'LogItemDetach':
                return ItemDetach::make($data)->setDate($data['_D']);
            case 'LogItemDrop':
                return ItemDrop::make($data)->setDate($data['_D']);
            case 'LogItemEquip':
                return ItemEquip::make($data)->setDate($data['_D']);
            case 'LogItemPickup':
                return ItemPickup::make($data)->setDate($data['_D']);
            case 'LogItemPickupFromCarepackage':
                return ItemPickupFromCarePackage::make($data)->setDate($data['_D']);
            case 'LogItemPickupFromCustomPackage':
                return ItemPickupFromCustomPackage::make($data)->setDate($data['_D']);
            case 'LogItemPickupFromLootBox':
                return ItemPickupFromLootBox::make($data)->setDate($data['_D']);
            case 'LogItemPickupFromVehicleTrunk':
                return ItemPickupFromVehicleTrunk::make($data)->setDate($data['_D']);
            case 'LogItemPutToVehicleTrunk':
                return ItemPutToVehicleTrunk::make($data)->setDate($data['_D']);
            case 'LogItemUnequip':
                return ItemUnequip::make($data)->setDate($data['_D']);
            case 'LogItemUse':
                return ItemUse::make($data)->setDate($data['_D']);
            case 'LogMatchDefinition':
                return MatchDefinition::make($data)->setDate($data['_D']);
            case 'LogMatchEnd':
                return MatchEnd::make($data)->setDate($data['_D']);
            case 'LogMatchStart':
                return MatchStart::make($data)->setDate($data['_D']);
            case 'LogObjectDestroy':
                return ObjectDestroy::make($data)->setDate($data['_D']);
            case 'LogObjectInteraction':
                return ObjectInteraction::make($data)->setDate($data['_D']);
            case 'LogParachuteLanding':
                return ParachuteLanding::make($data)->setDate($data['_D']);
            case 'LogPhaseChange':
                return PhaseChange::make($data)->setDate($data['_D']);
            case 'LogPlayerAttack':
                return PlayerAttack::make($data)->setDate($data['_D']);
            case 'LogPlayerLogin':
                return PlayerLogin::make($data)->setDate($data['_D']);
            case 'LogPlayerLogout':
                return PlayerLogout::make($data)->setDate($data['_D']);
            case 'LogPlayerCreate':
                return PlayerCreate::make($data)->setDate($data['_D']);
            case 'LogPlayerDestroyProp':
                return PlayerDestroyProp::make($data)->setDate($data['_D']);
            case 'LogPlayerKillV2':
                return PlayerKillV2::make($data)->setDate($data['_D']);
            case 'LogPlayerMakeGroggy':
                return PlayerMakeGroggy::make($data)->setDate($data['_D']);
            case 'LogPlayerPosition':
                return PlayerPosition::make($data)->setDate($data['_D']);
            case 'LogPlayerRevive':
                return PlayerRevive::make($data)->setDate($data['_D']);
            case 'LogPlayerTakeDamage':
                return PlayerTakeDamage::make($data)->setDate($data['_D']);
            case 'LogPlayerUseFlareGun':
                return PlayerUseFlareGun::make($data)->setDate($data['_D']);
            case 'LogPlayerUseThrowable':
                return PlayerUseThrowable::make($data)->setDate($data['_D']);
            case 'LogSwimEnd':
                return SwimEnd::make($data)->setDate($data['_D']);
            case 'LogSwimStart':
                return SwimStart::make($data)->setDate($data['_D']);
            case 'LogVaultStart':
                return VaultStart::make($data)->setDate($data['_D']);
            case 'LogVehicleRide':
                return VehicleRide::make($data)->setDate($data['_D']);
            case 'LogVehicleDamage':
                return VehicleDamage::make($data)->setDate($data['_D']);
            case 'LogVehicleDestroy':
                return VehicleDestroy::make($data)->setDate($data['_D']);
            case 'LogVehicleLeave':
                return VehicleLeave::make($data)->setDate($data['_D']);
            case 'LogWeaponFireCount':
                return WeaponFireCount::make($data)->setDate($data['_D']);
            case 'LogWheelDestroy':
                return WheelDestroy::make($data)->setDate($data['_D']);
            default:
                // dd($data);
                return $data;
        }
    }
}
