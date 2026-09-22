<?php

declare(strict_types=1);

use Bluezone\Requests\StatusRequest;

it('reports the api online', function () {
    expect(mockBluezone([StatusRequest::class => apiFixture('status')])->status()->get()->isOnline())->toBeTrue();
});

it('exposes release metadata', function () {
    $status = mockBluezone([StatusRequest::class => apiFixture('status')])->status()->get();

    expect($status->releasedAt)->toBeNull()->and($status->version)->toBeNull();
});
