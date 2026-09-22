<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class ParachuteLanding extends TelemetryEvent
{
    public string $type = 'parachute landing';

    public function __construct(
        public readonly Character $character,
        public readonly float $distance,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            character: Character::make($data['character']),
            distance: $data['distance'],
            common: Common::make($data['common']),
        );
    }
}
