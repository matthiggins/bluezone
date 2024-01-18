<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;
use Bluezone\DTOs\TelemetryObjects\Item;
use Carbon\Carbon;

class PlayerUseFlareGun extends AbstractEventDTO
{
    public string $type = 'player use flare gun';

    public function __construct(
        readonly public int $attackId,
        readonly public int $fireWeaponStackCount,
        readonly public Character $attacker,
        readonly public string $attackType,
        readonly public Item $weapon,
        readonly public Common $common,
        readonly public Carbon $timestamp,
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
            common: Common::fromEvent($data['common']),
            timestamp: Carbon::parse($data['_D']),
        );
    }
}
