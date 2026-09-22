<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Location;

class ObjectDestroy extends TelemetryEvent
{
    public string $type = 'object destroy';

    public function __construct(
        public readonly Character $character,
        public readonly string $objectType,
        public readonly ?Location $objectLocation,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            objectType: $data['objectType'],
            objectLocation: isset($data['objectLocation']) ? Location::make($data['objectLocation']) : null,
            common: Common::make($data['common']),
        );
    }
}
