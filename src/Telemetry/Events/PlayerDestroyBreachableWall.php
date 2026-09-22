<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\Item;

final class PlayerDestroyBreachableWall extends TelemetryEvent
{
    public string $type = 'player destroy breachable wall';

    /** @param  array<int, string>  $weaponAdditionalInfo */
    public function __construct(
        public readonly Character $attacker,
        public readonly Item|string $weapon,
        public readonly array $weaponAdditionalInfo,
        public readonly Common $common,
    ) {}

    /** @param  array<string, mixed>  $data */
    public static function make(array $data): self
    {
        return new self(
            attacker: Character::make($data['attacker']),
            weapon: is_array($data['weapon'] ?? null) ? Item::make($data['weapon']) : ($data['weapon'] ?? ''),
            weaponAdditionalInfo: $data['weaponAdditionalInfo'] ?? [],
            common: Common::make($data['common']),
        );
    }
}
