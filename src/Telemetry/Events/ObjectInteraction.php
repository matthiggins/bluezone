<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Location;

final class ObjectInteraction extends TelemetryEvent
{
    public string $type = 'object interaction';

    public function __construct(
        public readonly Character $character,
        public readonly string $objectType,
        public readonly ?Location $objectLocation,
        public readonly Common $common,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            character: Character::make($data['character']),
            objectType: $data['objectType'],
            objectLocation: isset($data['objectLocation']) ? Location::make($data['objectLocation']) : null,
            common: Common::make($data['common']),
        );
    }
}
