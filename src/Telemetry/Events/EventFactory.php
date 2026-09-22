<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

final class EventFactory
{
    /** @var array<string, class-string<TelemetryEvent>> */
    public const array EVENTS = [
        'LogArmorDestroy' => ArmorDestroy::class,
        'LogBlackZoneEnded' => BlackZoneEnded::class,
        'LogCarePackageLand' => CarePackageLand::class,
        'LogCarePackageSpawn' => CarePackageSpawn::class,
        'LogCharacterCarry' => CharacterCarry::class,
        'LogEmPickupLiftOff' => EmPickupLiftOff::class,
        'LogGameStatePeriodic' => GameStatePeriodic::class,
        'LogHeal' => Heal::class,
        'LogItemAttach' => ItemAttach::class,
        'LogItemDetach' => ItemDetach::class,
        'LogItemDrop' => ItemDrop::class,
        'LogItemEquip' => ItemEquip::class,
        'LogItemPickup' => ItemPickup::class,
        'LogItemPickupFromCarepackage' => ItemPickupFromCarePackage::class,
        'LogItemPickupFromCustomPackage' => ItemPickupFromCustomPackage::class,
        'LogItemPickupFromLootBox' => ItemPickupFromLootBox::class,
        'LogItemPickupFromVehicleTrunk' => ItemPickupFromVehicleTrunk::class,
        'LogItemPutToVehicleTrunk' => ItemPutToVehicleTrunk::class,
        'LogItemUnequip' => ItemUnequip::class,
        'LogItemUse' => ItemUse::class,
        'LogMatchDefinition' => MatchDefinition::class,
        'LogMatchEnd' => MatchEnd::class,
        'LogMatchStart' => MatchStart::class,
        'LogObjectDestroy' => ObjectDestroy::class,
        'LogObjectInteraction' => ObjectInteraction::class,
        'LogParachuteLanding' => ParachuteLanding::class,
        'LogPhaseChange' => PhaseChange::class,
        'LogPlayerAttack' => PlayerAttack::class,
        'LogPlayerCreate' => PlayerCreate::class,
        'LogPlayerDestroyBreachableWall' => PlayerDestroyBreachableWall::class,
        'LogPlayerDestroyProp' => PlayerDestroyProp::class,
        'LogPlayerKillV2' => PlayerKillV2::class,
        'LogPlayerLogin' => PlayerLogin::class,
        'LogPlayerLogout' => PlayerLogout::class,
        'LogPlayerMakeGroggy' => PlayerMakeGroggy::class,
        'LogPlayerPosition' => PlayerPosition::class,
        'LogPlayerRevive' => PlayerRevive::class,
        'LogPlayerTakeDamage' => PlayerTakeDamage::class,
        'LogPlayerUseFlareGun' => PlayerUseFlareGun::class,
        'LogPlayerUseThrowable' => PlayerUseThrowable::class,
        'LogRedZoneEnded' => RedZoneEnded::class,
        'LogSpecialZoneInCharacters' => SpecialZoneInCharacters::class,
        'LogSwimEnd' => SwimEnd::class,
        'LogSwimStart' => SwimStart::class,
        'LogVaultStart' => VaultStart::class,
        'LogVehicleDamage' => VehicleDamage::class,
        'LogVehicleDestroy' => VehicleDestroy::class,
        'LogVehicleLeave' => VehicleLeave::class,
        'LogVehicleRide' => VehicleRide::class,
        'LogWeaponFireCount' => WeaponFireCount::class,
        'LogWheelDestroy' => WheelDestroy::class,
    ];

    public static function supports(string $type): bool
    {
        return isset(self::EVENTS[$type]);
    }

    /**
     * @param  array<string, mixed>  $data  one decoded telemetry event
     * @return TelemetryEvent|null null when the `_T` has no DTO yet
     */
    public static function make(array $data): ?TelemetryEvent
    {
        $class = self::EVENTS[$data['_T'] ?? ''] ?? null;

        if ($class === null) {
            return null;
        }

        return $class::make($data)
            ->setEventType($data['_T'])
            ->setDate($data['_D'] ?? null);
    }
}
