<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class RedZoneEnded extends TelemetryEvent
{
    public string $type = 'red zone ended';

    /** @param  array<int, Character>  $drivers */
    public function __construct(
        public readonly array $drivers,
        public readonly Common $common,
    ) {}

    /** @param  array<string, mixed>  $data */
    public static function make(array $data): self
    {
        return new self(
            drivers: array_map(Character::make(...), $data['drivers'] ?? []),
            common: Common::make($data['common']),
        );
    }
}
