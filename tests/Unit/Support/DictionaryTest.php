<?php

declare(strict_types=1);

use Bluezone\Support\Dictionary;

it('translates known ids and echoes unknown ones', function () {
    expect(Dictionary::get('telemetry/mapName.json', 'Baltic_Main'))->toBe('Erangel (Remastered)')
        ->and(Dictionary::get('telemetry/item/itemId.json', 'Item_Weapon_AK47_C'))->toBe('AKM')
        ->and(Dictionary::get('telemetry/item/itemId.json', 'Item_Not_Real'))->toBe('Item_Not_Real')
        ->and(Dictionary::get('telemetry/mapName.json', ''))->toBe('');
});

it('reads each file from disk once', function () {
    Dictionary::flush();
    $before = memory_get_usage();
    for ($i = 0; $i < 20000; $i++) {
        Dictionary::get('telemetry/item/itemId.json', 'Item_Weapon_AK47_C');
    }
    expect(memory_get_usage() - $before)->toBeLessThan(2_000_000);
});
