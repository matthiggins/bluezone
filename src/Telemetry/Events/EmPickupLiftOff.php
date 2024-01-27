<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Illuminate\Support\Collection;

class EmPickupLiftOff extends TelemetryEvent
{
    public string $type = 'emergency pickup lift off';

    public function __construct(
        readonly public Character $instigator,
        readonly public Collection $riders,
        readonly public Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new static(
            instigator: Character::make($data['instigator']),
            riders: collect($data['riders'])->map(fn($rider) => Character::make($rider)),
            common: Common::make($data['common']),
        );
    }
}
