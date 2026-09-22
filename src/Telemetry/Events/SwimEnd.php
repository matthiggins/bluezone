<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class SwimEnd extends TelemetryEvent
{
    public string $type = 'swim end';

    public function __construct(
        public readonly Character $character,
        public readonly float $swimDistance,
        public readonly float $maxSwimDepthOfWater,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            character: Character::make($data['character']),
            swimDistance: $data['swimDistance'],
            maxSwimDepthOfWater: $data['maxSwimDepthOfWater'],
            common: Common::make($data['common']),
        );
    }
}
