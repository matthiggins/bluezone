<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryEvents;

use PubgApi\DTOs\TelemetryObjects\Character;
use PubgApi\DTOs\TelemetryObjects\Item;
use PubgApi\DTOs\TelemetryObjects\Vehicle;

class PlayerAttack extends AbstractEventDTO
{
    public string $type = 'player attack';

    public function __construct(
        readonly public int $attackId,
        readonly public int $fireWeaponStackCount,
        readonly public Character $attacker,
        readonly public string $attackType,
        readonly public Item $weapon,
        readonly public Vehicle|null $vehicle,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            fireWeaponStackCount: $data['fireWeaponStackCount'],
            attacker: Character::fromEvent($data['attacker']),
            attackType: $data['attackType'],
            weapon: Item::fromEvent($data['weapon']),
            vehicle: $data['vehicle'] ? Vehicle::fromEvent($data['vehicle']) : null,
        );
    }
}
