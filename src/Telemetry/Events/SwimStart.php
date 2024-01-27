<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

class SwimStart extends TelemetryEvent
{
    public string $type = 'swim start';

    public function __construct(
        readonly public Character $character,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            common: Common::make($data['common']),
        );
    }
}
