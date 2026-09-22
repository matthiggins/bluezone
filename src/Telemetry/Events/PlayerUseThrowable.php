<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

final class PlayerUseThrowable extends TelemetryEvent
{
    public string $type = 'player use throwable';

    public function __construct(
        public readonly int $attackId,
        public readonly int $fireWeaponStackCount,
        public readonly Character $attacker,
        public readonly string $attackType,
        public readonly Item $weapon,
        public readonly Common $common,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            attackId: $data['attackId'],
            fireWeaponStackCount: $data['fireWeaponStackCount'],
            attacker: Character::make($data['attacker']),
            attackType: $data['attackType'],
            weapon: Item::make($data['weapon']),
            common: Common::make($data['common']),
        );
    }
}
