<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class BlackZoneEnded extends TelemetryEvent
{
    public string $type = 'black zone ended';

    /** @param  array<int, Character>  $survivors */
    public function __construct(
        public readonly array $survivors,
        public readonly Common $common,
    ) {}

    /** @param  array<string, mixed>  $data */
    public static function make(array $data): static
    {
        return new self(
            survivors: array_map(Character::make(...), $data['survivors'] ?? []),
            common: Common::make($data['common']),
        );
    }
}
