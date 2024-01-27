<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

class ParachuteLanding extends TelemetryEvent
{
    public string $type = 'parachute landing';

    public function __construct(
        readonly public Character $character,
        readonly public float $distance,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            distance: $data['distance'],
            common: Common::make($data['common']),
        );
    }
}
