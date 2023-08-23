<?php

namespace Tests\Feature;

use Bluezone\Bluezone;
use Bluezone\DTOs\PubgMatch;
use Bluezone\DTOs\Telemetry;
use Bluezone\DTOs\TelemetryEvents\ArmorDestroy;
use Bluezone\DTOs\TelemetryEvents\CarePackageLand;
use Bluezone\DTOs\TelemetryEvents\CarePackageSpawn;
use Bluezone\DTOs\TelemetryEvents\GameStatePeriodic;
use Bluezone\DTOs\TelemetryEvents\Heal;
use Bluezone\DTOs\TelemetryEvents\ItemAttach;
use Bluezone\DTOs\TelemetryEvents\ItemDetach;
use Bluezone\DTOs\TelemetryEvents\ItemDrop;
use Bluezone\DTOs\TelemetryEvents\ItemEquip;
use Bluezone\DTOs\TelemetryEvents\ItemPickup;
use Bluezone\DTOs\TelemetryEvents\ItemUnequip;
use Bluezone\DTOs\TelemetryEvents\ItemUse;
use Bluezone\DTOs\TelemetryEvents\MatchDefinition;
use Bluezone\DTOs\TelemetryEvents\MatchEnd;
use Bluezone\DTOs\TelemetryEvents\MatchStart;
use Bluezone\DTOs\TelemetryEvents\ObjectDestroy;
use Bluezone\DTOs\TelemetryEvents\ObjectInteraction;
use Bluezone\DTOs\TelemetryEvents\ParachuteLanding;
use Bluezone\DTOs\TelemetryEvents\PhaseChange;
use Bluezone\DTOs\TelemetryEvents\PlayerAttack;
use Bluezone\DTOs\TelemetryEvents\PlayerCreate;
use Bluezone\DTOs\TelemetryEvents\PlayerKillV2;
use Bluezone\DTOs\TelemetryEvents\PlayerLogin;
use Bluezone\DTOs\TelemetryEvents\PlayerLogout;
use Bluezone\DTOs\TelemetryEvents\PlayerMakeGroggy;
use Bluezone\DTOs\TelemetryEvents\PlayerPosition;
use Bluezone\DTOs\TelemetryEvents\PlayerTakeDamage;
use Bluezone\DTOs\TelemetryEvents\PlayerUseThrowable;
use Bluezone\DTOs\TelemetryEvents\SwimEnd;
use Bluezone\DTOs\TelemetryEvents\SwimStart;
use Bluezone\DTOs\TelemetryEvents\VaultStart;
use Bluezone\DTOs\TelemetryEvents\VehicleDestroy;
use Bluezone\DTOs\TelemetryEvents\VehicleLeave;
use Bluezone\DTOs\TelemetryEvents\VehicleRide;
use Bluezone\DTOs\TelemetryEvents\WeaponFireCount;
use Bluezone\DTOs\TelemetryEvents\WheelDestroy;

/**
src/DTOs/TelemetryEvents/GameStatePeriodic.php
src/DTOs/TelemetryEvents/Heal.php
src/DTOs/TelemetryEvents/ItemAttach.php
src/DTOs/TelemetryEvents/ItemDetach.php
src/DTOs/TelemetryEvents/ItemDrop.php
src/DTOs/TelemetryEvents/ItemEquip.php
src/DTOs/TelemetryEvents/ItemPickup.php
src/DTOs/TelemetryEvents/ItemPickupFromCarePackage.php
src/DTOs/TelemetryEvents/ItemPickupFromCustomPackage.php
src/DTOs/TelemetryEvents/ItemPickupFromLootBox.php
src/DTOs/TelemetryEvents/ItemUnequip.php
src/DTOs/TelemetryEvents/ItemUse.php
src/DTOs/TelemetryEvents/MatchDefinition.php
src/DTOs/TelemetryEvents/MatchEnd.php
src/DTOs/TelemetryEvents/MatchStart.php
src/DTOs/TelemetryEvents/ObjectDestroy.php
src/DTOs/TelemetryEvents/ObjectInteraction.php
src/DTOs/TelemetryEvents/ParachuteLanding.php
src/DTOs/TelemetryEvents/PhaseChange.php
src/DTOs/TelemetryEvents/PlayerAttack.php
src/DTOs/TelemetryEvents/PlayerCreate.php
src/DTOs/TelemetryEvents/PlayerKillV2.php
src/DTOs/TelemetryEvents/PlayerLogin.php
src/DTOs/TelemetryEvents/PlayerLogout.php
src/DTOs/TelemetryEvents/PlayerMakeGroggy.php
src/DTOs/TelemetryEvents/PlayerPosition.php
src/DTOs/TelemetryEvents/PlayerTakeDamage.php
src/DTOs/TelemetryEvents/PlayerUseThrowable.php
src/DTOs/TelemetryEvents/SwimEnd.php
src/DTOs/TelemetryEvents/SwimStart.php
src/DTOs/TelemetryEvents/VaultStart.php
src/DTOs/TelemetryEvents/VehicleDamage.php
src/DTOs/TelemetryEvents/VehicleDestroy.php
src/DTOs/TelemetryEvents/VehicleLeave.php
src/DTOs/TelemetryEvents/VehicleRide.php
src/DTOs/TelemetryEvents/WeaponFireCount.php
src/DTOs/TelemetryEvents/WheelDestroy.php
 */
$accountId = env('PUBG_TEST_ACCOUNT_ID');
$shard = env('PUBG_TEST_SHARD');
$matchId = env('PUBG_TEST_MATCH_ID');
$bluezone = new Bluezone(env('PUBG_TEST_API_KEY'));

$match = $bluezone->match()->find($shard, $matchId);
$telemetry = $match->getTelemetry();

it('can get match telemetry', function () use ($match) {
    expect($match->getResponse()->successful())->toBeTrue();
    expect($match instanceof PubgMatch)->toBeTrue();
    expect($match->getTelemetry() instanceof Telemetry)->toBeTrue();
});

it('has armor destroy event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ArmorDestroy))->toBeTrue();
});
it('has care package land event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof CarePackageLand))->toBeTrue();
});
it('has care package spawn event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof CarePackageSpawn))->toBeTrue();
});
it('has game state periodic event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof GameStatePeriodic))->toBeTrue();
});
it('has heal event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof Heal))->toBeTrue();
});
it('has item attach event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ItemAttach))->toBeTrue();
});
it('has item detatch event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ItemDetach))->toBeTrue();
});
it('has item drop event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ItemDrop))->toBeTrue();
});
it('has item equip event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ItemEquip))->toBeTrue();
});
it('has item pickup event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ItemPickup))->toBeTrue();
});
it('has item unequip event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ItemUnequip))->toBeTrue();
});
it('has item use event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ItemUse))->toBeTrue();
});
it('has match definition event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof MatchDefinition))->toBeTrue();
});
it('has match end event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof MatchEnd))->toBeTrue();
});
it('has match start event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof MatchStart))->toBeTrue();
});
it('has object destroy event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ObjectDestroy))->toBeTrue();
});
it('has object interaction event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ObjectInteraction))->toBeTrue();
});
it('has parachute landing event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof ParachuteLanding))->toBeTrue();
});
it('has phase change event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PhaseChange))->toBeTrue();
});
it('has player attack event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PlayerAttack))->toBeTrue();
});
it('has player create event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PlayerCreate))->toBeTrue();
});
it('has player kill v2 event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PlayerKillV2))->toBeTrue();
});
it('has player login event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PlayerLogin))->toBeTrue();
});
it('has player logout event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PlayerLogout))->toBeTrue();
});
it('has player make groggy event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PlayerMakeGroggy))->toBeTrue();
});
it('has player position event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PlayerPosition))->toBeTrue();
});
it('has player take damage event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PlayerTakeDamage))->toBeTrue();
});
it('has player use throwable event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof PlayerUseThrowable))->toBeTrue();
});
it('has swim end event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof SwimEnd))->toBeTrue();
});
it('has swim start event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof SwimStart))->toBeTrue();
});
it('has vault start event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof VaultStart))->toBeTrue();
});
it('has vehicle destroy event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof VehicleDestroy))->toBeTrue();
});
it('has vehicle leave event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof VehicleLeave))->toBeTrue();
});
it('has vehicle ride event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof VehicleRide))->toBeTrue();
});
it('has weapon fire count event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof WeaponFireCount))->toBeTrue();
});
it('has wheel destroy event', function () use ($telemetry) {
    expect($telemetry->events()->contains(fn ($event) => $event instanceof WheelDestroy))->toBeTrue();
});
