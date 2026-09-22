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

    expect(Dictionary::loaded())->toBe([]);

    for ($i = 0; $i < 100; $i++) {
        Dictionary::get('telemetry/item/itemId.json', 'Item_Weapon_AK47_C');
    }
    Dictionary::get('telemetry/mapName.json', 'Baltic_Main');

    expect(Dictionary::loaded())->toBe(['telemetry/item/itemId.json', 'telemetry/mapName.json']);
});
