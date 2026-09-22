<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\SpecialZone;

final class SpecialZoneInCharacters extends TelemetryEvent
{
    public string $type = 'special zone in characters';

    /** @param  array<int, Character>  $charactersInZone */
    public function __construct(
        public readonly SpecialZone $zoneInfo,
        public readonly array $charactersInZone,
        public readonly Common $common,
    ) {}

    /** @param  array<string, mixed>  $data */
    public static function make(array $data): static
    {
        return new self(
            zoneInfo: SpecialZone::make($data['zoneInfo']),
            charactersInZone: array_map(Character::make(...), $data['charactersInZone'] ?? []),
            common: Common::make($data['common']),
        );
    }
}
