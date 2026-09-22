<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class WeaponFireCount extends TelemetryEvent
{
    public string $type = 'weapon fire count';

    public function __construct(
        public readonly Character $character,
        public readonly string $weaponId,
        public readonly int $fireCount,
        public readonly Common $common,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            character: Character::make($data['character']),
            weaponId: $data['weaponId'],
            fireCount: (int) $data['fireCount'],
            common: Common::make($data['common']),
        );
    }
}
