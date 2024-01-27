<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

class SwimEnd extends TelemetryEvent
{
    public string $type = 'swim end';

    public function __construct(
        readonly public Character $character,
        readonly public float $swimDistance,
        readonly public float $maxSwimDepthOfWater,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            swimDistance: $data['swimDistance'],
            maxSwimDepthOfWater: $data['maxSwimDepthOfWater'],
            common: Common::make($data['common']),
        );
    }
}
