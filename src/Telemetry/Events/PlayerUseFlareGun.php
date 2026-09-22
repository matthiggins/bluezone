<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;
use Carbon\Carbon;

final class PlayerUseFlareGun extends TelemetryEvent
{
    public string $type = 'player use flare gun';

    public function __construct(
        public readonly int $attackId,
        public readonly int $fireWeaponStackCount,
        public readonly Character $attacker,
        public readonly string $attackType,
        public readonly Item $weapon,
        public readonly Common $common,
        public readonly Carbon $timestamp,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            attackId: (int) $data['attackId'],
            fireWeaponStackCount: (int) $data['fireWeaponStackCount'],
            attacker: Character::make($data['attacker']),
            attackType: $data['attackType'],
            weapon: Item::make($data['weapon']),
            common: Common::make($data['common']),
            timestamp: Carbon::parse($data['_D']),
        );
    }
}
