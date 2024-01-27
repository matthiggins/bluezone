<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

class CharacterCarry extends TelemetryEvent
{
    public string $type = 'player revive';

    public function __construct(
        readonly public Character $character,
        readonly public string $carryState,
        readonly public Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            carryState: $data['carryState'],
            common: Common::make($data['common']),
        );
    }
}
