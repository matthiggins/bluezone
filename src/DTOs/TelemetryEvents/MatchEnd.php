<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\AllWeaponStats;
use Bluezone\DTOs\TelemetryObjects\CharacterWrapper;
use Bluezone\DTOs\TelemetryObjects\Common;
use Bluezone\DTOs\TelemetryObjects\GameResultOnFinished;

class MatchEnd extends AbstractEventDTO
{
    public string $type = 'match end';

    public function __construct(
        readonly public array $characters,
        readonly public GameResultOnFinished $gameResultOnFinished,
        readonly public array $allWeaponStats,
        readonly public Common $common,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            characters: array_map(fn ($character) => CharacterWrapper::fromEvent($character), $data['characters']),
            gameResultOnFinished: GameResultOnFinished::fromEvent($data['gameResultOnFinished']),
            allWeaponStats: array_map(fn ($weaponStats) => AllWeaponStats::fromEvent($weaponStats), $data['allWeaponStats']),
            common: Common::fromEvent($data['common']),
        );
    }
}
