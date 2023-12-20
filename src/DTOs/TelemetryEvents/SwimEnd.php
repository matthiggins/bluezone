<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;

class SwimEnd extends AbstractEventDTO
{
    public string $type = 'swim end';

    public function __construct(
        readonly public Character $character,
        readonly public float $swimDistance,
        readonly public float $maxSwimDepthOfWater,
        readonly public Common $common,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            character: Character::fromEvent($data['character']),
            swimDistance: $data['swimDistance'],
            maxSwimDepthOfWater: $data['maxSwimDepthOfWater'],
            common: Common::fromEvent($data['common']),
        );
    }
}
