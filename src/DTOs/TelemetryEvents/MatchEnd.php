<?php

declare(strict_types=1);

namespace LaravelPubg\DTOs\TelemetryEvents;

use LaravelPubg\DTOs\TelemetryObjects\AllWeaponStats;
use LaravelPubg\DTOs\TelemetryObjects\CharacterWrapper;
use LaravelPubg\DTOs\TelemetryObjects\GameResultOnFinished;

class MatchEnd extends AbstractEventDTO
{
    public string $type = 'match end';

    public function __construct(
        readonly public array $characters,
        readonly public GameResultOnFinished $gameResultOnFinished,
        readonly public array $allWeaponStats,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            characters: array_map(fn ($character) => CharacterWrapper::fromEvent($character), $data['characters']),
            gameResultOnFinished: GameResultOnFinished::fromEvent($data['gameResultOnFinished']),
            allWeaponStats: array_map(fn ($weaponStats) => AllWeaponStats::fromEvent($weaponStats), $data['allWeaponStats']),
        );
    }
}
