<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;
use Carbon\Carbon;

class PlayerUseFlareGun extends TelemetryEvent
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

    public static function make(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            fireWeaponStackCount: $data['fireWeaponStackCount'],
            attacker: Character::make($data['attacker']),
            attackType: $data['attackType'],
            weapon: Item::make($data['weapon']),
            common: Common::make($data['common']),
            timestamp: Carbon::parse($data['_D']),
        );
    }
}
