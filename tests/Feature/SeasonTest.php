<?php

declare(strict_types=1);

use Bluezone\Requests\SeasonsRequest;

it('lists seasons and identifies the current one', function () {
    $seasons = mockBluezone([SeasonsRequest::class => apiFixture('seasons')])->season()->all('steam');

    expect($seasons->seasons->count())->toBeGreaterThan(100)
        ->and($seasons->currentSeason()->id)->toBe('division.bro.official.pc-2018-43')
        ->and($seasons->currentSeason()->isOffSeason)->toBeFalse();
});
