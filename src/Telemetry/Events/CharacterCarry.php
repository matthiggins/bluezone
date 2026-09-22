<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class CharacterCarry extends TelemetryEvent
{
    public string $type = 'player revive';

    public function __construct(
        public readonly Character $character,
        public readonly string $carryState,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            character: Character::make($data['character']),
            carryState: $data['carryState'],
            common: Common::make($data['common']),
        );
    }
}
