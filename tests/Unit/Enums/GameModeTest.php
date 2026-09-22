<?php

declare(strict_types=1);

use Bluezone\Enums\GameMode;

it('labels modes from the dictionary', function () {
    expect(GameMode::SquadFpp->label())->toBe('Squad FPP')
        ->and(GameMode::Solo->label())->toBe('Solo TPP');
});

it('knows perspective and team size', function () {
    expect(GameMode::DuoFpp->isFpp())->toBeTrue()
        ->and(GameMode::Duo->isFpp())->toBeFalse()
        ->and(GameMode::Squad->teamSize())->toBe(4)
        ->and(GameMode::Solo->teamSize())->toBe(1);
});

it('lists the six battle royale modes in display order', function () {
    expect(array_map(fn (GameMode $m) => $m->value, GameMode::battleRoyale()))
        ->toBe(['solo', 'solo-fpp', 'duo', 'duo-fpp', 'squad', 'squad-fpp']);
});
