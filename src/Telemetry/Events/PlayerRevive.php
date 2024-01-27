<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Concerns\AccessesJsonDictionaries;
use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

class PlayerRevive extends TelemetryEvent
{
    public string $type = 'player revive';

    public function __construct(
        readonly public Character|null $reviver,
        readonly public Character $victim,
        readonly public int $dBNOId,
        readonly public Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new static(
            reviver: $data['reviver'] ? Character::make($data['reviver']) : null,
            victim: Character::make($data['victim']),
            dBNOId: $data['dBNOId'],
            common: Common::make($data['common']),
        );
    }
}
