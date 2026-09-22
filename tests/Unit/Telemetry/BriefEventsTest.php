<?php

declare(strict_types=1);

use Bluezone\Telemetry\Events\BlackZoneEnded;
use Bluezone\Telemetry\Events\EventFactory;
use Bluezone\Telemetry\Events\MatchEnd;
use Bluezone\Telemetry\Events\PlayerDestroyBreachableWall;
use Bluezone\Telemetry\Events\PlayerPosition;
use Bluezone\Telemetry\Events\PlayerTakeDamage;
use Bluezone\Telemetry\Events\RedZoneEnded;
use Bluezone\Telemetry\Objects\Item;

/**
 * These `_T` values are absent from the sample fixture, so the payloads are hand-built
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

it('parses per-weapon hit details with fractional damage', function () {
    $event = EventFactory::make([
        '_T' => 'LogMatchEnd',
        '_D' => '2026-01-01T00:00:00Z',
        'characters' => [[
            'character' => character('WamBo0_'),
            'primaryWeaponFirst' => 'Item_Weapon_AK47_C',
            'primaryWeaponSecond' => '',
            'secondaryWeapon' => '',
            'spawnKitIndex' => 0,
        ]],
        'gameResultOnFinished' => ['results' => [[
            'rank' => 1,
            'gameResult' => 'Win',
            'teamId' => 1,
            'stats' => [
                'killCount' => 3,
                'distanceOnFoot' => 1200.5,
                'distanceOnSwim' => 0.0,
                'distanceOnVehicle' => 4200.25,
                'distanceOnParachute' => 600.0,
                'distanceOnFreefall' => 300.0,
            ],
            'accountId' => 'account.WamBo0_',
        ]]],
        'allWeaponStats' => [[
            'accountId' => 'account.WamBo0_',
            'stats' => [[
                'weapon' => 'Item_Weapon_AK47_C',
                'damage' => 268.75,
                'dBNODamage' => 41.5,
                'shots' => 30,
                'hits' => 11,
                'dBNOHits' => 1,
                'holdingTime' => 420,
                'hitDetails' => [[
                    'bodyPart' => 'Head',
                    'kills' => 1,
                    'dBNOs' => 1,
                    'hits' => 2,
                    'dBNOHits' => 1,
                    'damage' => 148.35,
                    'dBNODamage' => 41.5,
                ]],
            ]],
        ]],
        'common' => ['isGame' => 9.5],
    ]);

    $weaponStats = $event->allWeaponStats[0]->stats[0];
    $hitDetails = $weaponStats->hitDetails[0];

    expect($event)->toBeInstanceOf(MatchEnd::class)
        ->and($weaponStats->damage)->toBe(268.75)
        ->and($weaponStats->dBNODamage)->toBe(41.5)
        ->and($hitDetails->bodyPart)->toBe('Head')
        ->and($hitDetails->damage)->toBe(148.35)
        ->and($hitDetails->dBNODamage)->toBe(41.5)
        ->and($hitDetails->hits)->toBe(2)
        ->and($event->gameResultOnFinished->results[0]->stats->distanceOnFoot)->toBe(1200.5);
});

/** PUBG writes whole numbers as JSON floats in places, so every scalar is cast at the call site. */
it('casts float payload values into int-typed event fields', function () {
    $character = ['teamId' => 3.0, 'health' => 100, 'ranking' => 0.0] + character('WamBo0_');

    $damage = EventFactory::make([
        '_T' => 'LogPlayerTakeDamage',
        '_D' => '2026-01-01T00:00:00Z',
        'attackId' => 918.0,
        'attacker' => $character,
        'victim' => $character,
        'damageTypeCategory' => 'Damage_Gun',
        'damageReason' => 'HeadShot',
        'damageCauserName' => 'WeapHK416_C',
        'damage' => 91,
        'isThroughPenetrableWall' => 0,
        'common' => ['isGame' => 3],
    ]);

    $position = EventFactory::make([
        '_T' => 'LogPlayerPosition',
        '_D' => '2026-01-01T00:00:00Z',
        'character' => $character,
        'vehicle' => null,
        'elapsedTime' => 612,
        'numAlivePlayers' => 42.0,
        'common' => ['isGame' => 3],
    ]);

    expect($damage)->toBeInstanceOf(PlayerTakeDamage::class)
        ->and($damage->attackId)->toBe(918)
        ->and($damage->damage)->toBe(91.0)
        ->and($damage->isThroughPenetrableWall)->toBeFalse()
        ->and($damage->attacker->teamId)->toBe(3)
        ->and($damage->attacker->health)->toBe(100.0)
        ->and($damage->common->isGame)->toBe(3.0)
        ->and($position)->toBeInstanceOf(PlayerPosition::class)
        ->and($position->numAlivePlayers)->toBe(42)
        ->and($position->elapsedTime)->toBe(612.0)
        ->and($position->character->ranking)->toBe(0);
});
