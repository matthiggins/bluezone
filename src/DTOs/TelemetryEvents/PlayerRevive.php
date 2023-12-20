<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\Concerns\AccessesJsonDictionaries;
use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;

class PlayerRevive extends AbstractEventDTO
{
    public string $type = 'player revive';

    public function __construct(
        readonly public Character|null $reviver,
        readonly public Character $victim,
        readonly public int $dBNOId,
        readonly public Common $common,
    ) {}

    public static function fromEvent(array $data): self
    {
        return new static(
            reviver: $data['reviver'] ? Character::fromEvent($data['reviver']) : null,
            victim: Character::fromEvent($data['victim']),
            dBNOId: $data['dBNOId'],
            common: Common::fromEvent($data['common']),
        );
    }
}
