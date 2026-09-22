<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class SwimStart extends TelemetryEvent
{
    public string $type = 'swim start';

    public function __construct(
        public readonly Character $character,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            character: Character::make($data['character']),
            common: Common::make($data['common']),
        );
    }
}
