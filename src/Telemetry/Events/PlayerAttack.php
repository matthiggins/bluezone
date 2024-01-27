<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;
use Bluezone\Telemetry\Objects\Vehicle;

class PlayerAttack extends TelemetryEvent
{
    public string $type = 'player attack';

    public function __construct(
        readonly public int $attackId,
        readonly public int $fireWeaponStackCount,
        readonly public Character $attacker,
        readonly public string $attackType,
        readonly public Item $weapon,
        readonly public Vehicle|null $vehicle,
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
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
