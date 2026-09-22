<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;
use Bluezone\Telemetry\Objects\Vehicle;

final class PlayerAttack extends TelemetryEvent
{
    public string $type = 'player attack';

    public function __construct(
        public readonly int $attackId,
        public readonly int $fireWeaponStackCount,
        public readonly Character $attacker,
        public readonly string $attackType,
        public readonly Item $weapon,
        public readonly ?Vehicle $vehicle,
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
            vehicle: $data['vehicle'] ? Vehicle::make($data['vehicle']) : null,
            common: Common::make($data['common']),
        );
    }
}
