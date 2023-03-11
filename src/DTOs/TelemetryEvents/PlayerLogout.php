<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryEvents;

use PubgApi\DTOs\TelemetryObjects\Common;

class PlayerLogout extends AbstractEventDTO
{
    public string $type = 'player logout';

    public function __construct(
        readonly public string $accountId,
        readonly public Common $common,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            accountId: $data['accountId'],
            common: Common::fromEvent($data['common']),
        );
    }
}
