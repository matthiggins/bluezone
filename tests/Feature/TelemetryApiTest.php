<?php

namespace Tests\Feature;

use Bluezone\Bluezone;
use Bluezone\Responses\PubgMatch;
use Bluezone\Responses\Telemetry;
use Bluezone\Telemetry\Events\TelemetryEvent;
use Bluezone\Telemetry\Events\ArmorDestroy;
use Bluezone\Telemetry\Events\CarePackageLand;
use Bluezone\Telemetry\Events\CarePackageSpawn;
use Bluezone\Telemetry\Events\GameStatePeriodic;
use Bluezone\Telemetry\Events\Heal;
use Bluezone\Telemetry\Events\ItemAttach;
use Bluezone\Telemetry\Events\ItemDetach;
use Bluezone\Telemetry\Events\ItemDrop;
use Bluezone\Telemetry\Events\ItemEquip;
use Bluezone\Telemetry\Events\ItemPickup;
use Bluezone\Telemetry\Events\ItemUnequip;
use Bluezone\Telemetry\Events\ItemUse;
use Bluezone\Telemetry\Events\MatchDefinition;
use Bluezone\Telemetry\Events\MatchEnd;
use Bluezone\Telemetry\Events\MatchStart;
use Bluezone\Telemetry\Events\ObjectDestroy;
use Bluezone\Telemetry\Events\ObjectInteraction;
use Bluezone\Telemetry\Events\ParachuteLanding;
use Bluezone\Telemetry\Events\PhaseChange;
use Bluezone\Telemetry\Events\PlayerAttack;
use Bluezone\Telemetry\Events\PlayerCreate;
use Bluezone\Telemetry\Events\PlayerKillV2;
use Bluezone\Telemetry\Events\PlayerLogin;
use Bluezone\Telemetry\Events\PlayerLogout;
use Bluezone\Telemetry\Events\PlayerMakeGroggy;
use Bluezone\Telemetry\Events\PlayerPosition;
use Bluezone\Telemetry\Events\PlayerTakeDamage;
use Bluezone\Telemetry\Events\PlayerUseThrowable;
use Bluezone\Telemetry\Events\SwimEnd;
use Bluezone\Telemetry\Events\SwimStart;
use Bluezone\Telemetry\Events\VaultStart;
use Bluezone\Telemetry\Events\VehicleDestroy;
use Bluezone\Telemetry\Events\VehicleLeave;
use Bluezone\Telemetry\Events\VehicleRide;
use Bluezone\Telemetry\Events\WeaponFireCount;
use Bluezone\Telemetry\Events\WheelDestroy;

$accountId = env('PUBG_TEST_ACCOUNT_ID');
$shard = env('PUBG_TEST_SHARD');
$matchId = env('PUBG_TEST_MATCH_ID');
$bluezone = new Bluezone(env('PUBG_TEST_API_KEY'));

$match = $bluezone->match()->find($shard, $matchId);
$telemetry = $match->getTelemetry();

it('can get match telemetry', function () use ($match) {
    expect($match instanceof PubgMatch)->toBeTrue();
    expect($match->getTelemetry() instanceof Telemetry)->toBeTrue();
});

it('does not have unmapped events', function() use ($telemetry){
    $unmappedEvents = $telemetry->events()->filter(fn ($event) => !($event instanceof TelemetryEvent));
    expect($unmappedEvents->count())->toBe(0);
});

it('does not have unmapped items', function() use ($telemetry){
    $telemetry->events();
})->throwsNoExceptions();

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
