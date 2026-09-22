<?php

declare(strict_types=1);

use Bluezone\Requests\SurvivalMasteryRequest;
use Bluezone\Requests\WeaponMasteryRequest;
use Bluezone\Responses\SurvivalStat;
use Bluezone\Responses\WeaponSummary;

it('types weapon mastery with translated names and medals', function () {
    $mastery = mockBluezone([WeaponMasteryRequest::class => apiFixture('weapon-mastery')])
        ->player()->weaponMastery('steam', 'account.48cf00fd16c548ca9f6c6091d2c82d1c');

    $ace = $mastery->weaponSummaries['Item_Weapon_ACE32_C'];

    expect($mastery->platform)->toBe('steam')
        ->and($ace)->toBeInstanceOf(WeaponSummary::class)
        ->and($ace->itemId)->toBe('Item_Weapon_ACE32_C')
        ->and($ace->name)->toBe('ACE32')
        ->and($ace->xpTotal)->toBe(952500)
        ->and($ace->levelCurrent)->toBe(99)
        ->and($ace->tierCurrent)->toBe(6)
        ->and($ace->statsTotal->kills)->toBe(623)
        ->and($ace->statsTotal->longestDefeat)->toBe(202.10809326171875)
        ->and($ace->statsTotal->longestKill)->toBeNull()
        ->and($ace->officialStatsTotal->longestKill)->toBe(564.0)
        ->and($ace->competitiveStatsTotal->kills)->toBe(6)
        ->and($ace->medals)->toBe([]);
});

it('types survival mastery stats', function () {
    $mastery = mockBluezone([SurvivalMasteryRequest::class => apiFixture('survival-mastery')])
        ->player()->survivalMastery('steam', 'account.48cf00fd16c548ca9f6c6091d2c82d1c');

    expect($mastery->level)->toBe(500)
        ->and($mastery->tier)->toBe(5)
        ->and($mastery->totalMatchesPlayed)->toBe(72894)
        ->and($mastery->stats['timeSurvived'])->toBeInstanceOf(SurvivalStat::class)
        ->and($mastery->stats['timeSurvived']->key)->toBe('timeSurvived')
        ->and($mastery->stats['timeSurvived']->lastMatchValue)->toBe(1686.0)
        ->and($mastery->stats['top10']->total)->toBe(0.0)
        ->and($mastery->stats['top10']->average)->toBeNull();
});
