<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;

final class PlayerRevive extends TelemetryEvent
{
    public string $type = 'player revive';

    public function __construct(
        public readonly ?Character $reviver,
        public readonly Character $victim,
        public readonly int $dBNOId,
        public readonly Common $common,
    ) {}

    public static function make(array $data): static
    {
        return new self(
            reviver: $data['reviver'] ? Character::make($data['reviver']) : null,
            victim: Character::make($data['victim']),
            dBNOId: (int) $data['dBNOId'],
            common: Common::make($data['common']),
        );
    }
}
