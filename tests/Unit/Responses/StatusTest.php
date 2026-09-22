<?php

declare(strict_types=1);

use Bluezone\Requests\StatusRequest;
use Bluezone\Responses\Status;
use Saloon\Http\Faking\MockResponse;

/** The recorded status fixture carries no attributes, so the release metadata path is exercised here. */
it('parses release metadata from the status attributes', function () {
    $status = mockBluezone([StatusRequest::class => MockResponse::make([
        'data' => [
            'type' => 'status',
            'id' => 'pubg-api',
            'attributes' => ['releasedAt' => '2026-09-16T09:00:00Z', 'version' => '34.0.0'],
        ],
    ])])->status()->get();

    expect($status)->toBeInstanceOf(Status::class)
        ->and($status->isOnline())->toBeTrue()
        ->and($status->releasedAt)->toBe('2026-09-16T09:00:00Z')
        ->and($status->version)->toBe('34.0.0');
});
