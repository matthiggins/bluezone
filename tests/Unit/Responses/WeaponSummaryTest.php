<?php

declare(strict_types=1);

use Bluezone\Responses\WeaponSummary;

/** The recorded weapon-mastery fixture carries no medals, so medal mapping is covered here instead. */
it('translates medal ids into names and descriptions', function () {
    $summary = WeaponSummary::fromArray('Item_Weapon_AK47_C', [
        'XPTotal' => 1000,
        'LevelCurrent' => 12,
        'TierCurrent' => 1,
        'StatsTotal' => ['Kills' => 5],
        'OfficialStatsTotal' => [],
        'CompetitiveStatsTotal' => [],
        'Medals' => [['MedalId' => 'MedalDeadeye', 'Count' => 3]],
    ]);

    expect($summary->name)->toBe('AKM')
        ->and($summary->medals[0]->medalId)->toBe('MedalDeadeye')
        ->and($summary->medals[0]->name)->toBe('Deadeye')
        ->and($summary->medals[0]->count)->toBe(3)
        ->and($summary->medals[0]->description)->not->toBe('');
});

it('falls back to the medal id when the medal is unknown', function () {
    $summary = WeaponSummary::fromArray('Item_Weapon_AK47_C', [
        'Medals' => [['MedalId' => 'MedalNotInDictionary', 'Count' => 1]],
    ]);

    expect($summary->medals[0]->name)->toBe('MedalNotInDictionary')
        ->and($summary->medals[0]->description)->toBe('');
});
