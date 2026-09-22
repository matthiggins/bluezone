<?php

declare(strict_types=1);

use Bluezone\Requests\ClanRequest;

it('finds a clan', function () {
    $clan = mockBluezone([ClanRequest::class => apiFixture('clan')])->clan()->find('steam', 'clan.7e41009b212341a5a62d46430b391533');

    expect($clan->id)->toBe('clan.7e41009b212341a5a62d46430b391533')
        ->and($clan->name)->toBeString()->not->toBe('')
        ->and($clan->memberCount)->toBeInt();
});
