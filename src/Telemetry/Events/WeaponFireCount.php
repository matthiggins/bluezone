<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

class WeaponFireCount extends TelemetryEvent
{
    public string $type = 'weapon fire count';

    public function __construct(
        readonly public Character $character,
        readonly public string $weaponId,
        readonly public int $fireCount,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            character: Character::make($data['character']),
            weaponId: $data['weaponId'],
            fireCount: $data['fireCount'],
            common: Common::make($data['common']),
        );
    }
}
