<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

class VaultStart extends TelemetryEvent
{
    public string $type = 'vault start';

    public function __construct(
        public readonly Character $character,
        public readonly bool $isLedgeGrab,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            isLedgeGrab: $data['isLedgeGrab'],
            common: Common::make($data['common']),
        );
    }
}
