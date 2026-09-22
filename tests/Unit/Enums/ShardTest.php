<?php

declare(strict_types=1);

use Bluezone\Enums\Shard;

it('resolves from string or enum', function () {
    expect(Shard::resolve('xbox'))->toBe(Shard::Xbox)
        ->and(Shard::resolve(Shard::Psn))->toBe(Shard::Psn);
});

it('rejects unknown shards', fn () => Shard::resolve('stadia'))->throws(ValueError::class);

it('knows console shards', function () {
    expect(Shard::Xbox->isConsole())->toBeTrue()
        ->and(Shard::Psn->isConsole())->toBeTrue()
        ->and(Shard::Console->isConsole())->toBeTrue()
        ->and(Shard::Steam->isConsole())->toBeFalse();
});

it('has human labels', function () {
    expect(Shard::Steam->label())->toBe('PC (Steam)')
        ->and(Shard::Kakao->label())->toBe('PC (Kakao)')
        ->and(Shard::Psn->label())->toBe('PlayStation');
});
