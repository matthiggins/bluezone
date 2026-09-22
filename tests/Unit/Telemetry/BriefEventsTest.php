<?php

declare(strict_types=1);

use Bluezone\Telemetry\Events\BlackZoneEnded;
use Bluezone\Telemetry\Events\EventFactory;
use Bluezone\Telemetry\Events\PlayerDestroyBreachableWall;
use Bluezone\Telemetry\Events\RedZoneEnded;
use Bluezone\Telemetry\Objects\Item;

/**
 * These four `_T` values are absent from the sample fixture, so the payloads are hand-built
 * from the PUBG telemetry docs rather than recorded.
 */
function character(string $name, int $teamId = 1): array
{
    return [
        'name' => $name,
        'teamId' => $teamId,
        'health' => 100.0,
        'location' => ['x' => 1.0, 'y' => 2.0, 'z' => 3.0],
        'ranking' => 0,
        'accountId' => 'account.'.$name,
        'isInBlueZone' => false,
        'isInRedZone' => true,
        'zone' => ['shipyard'],
    ];
}

it('parses the drivers caught by a red zone', function () {
    $event = EventFactory::make([
        '_T' => 'LogRedZoneEnded',
        '_D' => '2026-01-01T00:00:00Z',
        'drivers' => [character('WamBo0_'), character('ChaseHunt', 2)],
        'common' => ['isGame' => 1.5],
    ]);

    expect($event)->toBeInstanceOf(RedZoneEnded::class)
        ->and($event->drivers)->toHaveCount(2)
        ->and($event->drivers[0]->name)->toBe('WamBo0_')
        ->and($event->drivers[1]->teamId)->toBe(2)
        ->and($event->common->isGame)->toBe(1.5)
        ->and($event->eventType)->toBe('LogRedZoneEnded');
});

it('parses the survivors of a black zone', function () {
    $event = EventFactory::make([
        '_T' => 'LogBlackZoneEnded',
        '_D' => '2026-01-01T00:00:00Z',
        'survivors' => [character('WamBo0_')],
        'common' => ['isGame' => 2.0],
    ]);

    expect($event)->toBeInstanceOf(BlackZoneEnded::class)
        ->and($event->survivors)->toHaveCount(1)
        ->and($event->survivors[0]->accountId)->toBe('account.WamBo0_')
        ->and($event->common->isGame)->toBe(2.0);
});

it('parses a breached wall whose weapon is an item payload', function () {
    $event = EventFactory::make([
        '_T' => 'LogPlayerDestroyBreachableWall',
        '_D' => '2026-01-01T00:00:00Z',
        'attacker' => character('WamBo0_'),
        'weapon' => [
            'itemId' => 'Item_Weapon_AK47_C',
            'stackCount' => 1,
            'category' => 'Weapon',
            'subCategory' => 'Main',
            'attachedItems' => [],
        ],
        'weaponAdditionalInfo' => ['Item_Attach_Weapon_Muzzle_Compensator_Large_C'],
        'common' => ['isGame' => 1.0],
    ]);

    expect($event)->toBeInstanceOf(PlayerDestroyBreachableWall::class)
        ->and($event->attacker->name)->toBe('WamBo0_')
        ->and($event->weapon)->toBeInstanceOf(Item::class)
        ->and($event->weapon->itemName)->toBe('AKM')
        ->and($event->weaponAdditionalInfo)->toBe(['Item_Attach_Weapon_Muzzle_Compensator_Large_C']);
});

it('parses a breached wall whose weapon is a bare id', function () {
    $event = EventFactory::make([
        '_T' => 'LogPlayerDestroyBreachableWall',
        '_D' => '2026-01-01T00:00:00Z',
        'attacker' => character('WamBo0_'),
        'weapon' => 'Item_Weapon_AK47_C',
        'common' => ['isGame' => 1.0],
    ]);

    expect($event->weapon)->toBe('Item_Weapon_AK47_C')
        ->and($event->weaponAdditionalInfo)->toBe([]);
});
