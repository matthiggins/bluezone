<?php

declare(strict_types=1);

namespace PubgApi\DTOs\TelemetryEvents;

use PubgApi\DTOs\TelemetryObjects\CharacterWrapper;

class MatchStart extends AbstractEventDTO
{
    public string $type = 'match start';

    public function __construct(
        readonly public string $mapName,
        readonly public string $weatherId,
        readonly public array $characters,
        readonly public string $cameraViewBehaviour,
        readonly public int $teamSize,
        readonly public bool $isCustomGame,
        readonly public bool $isEventMode,
        readonly public string $blueZoneCustomOptions,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            mapName: $data['mapName'],
            weatherId: $data['weatherId'],
            characters: array_map(fn ($character) => CharacterWrapper::fromEvent($character), $data['characters']),
            cameraViewBehaviour: $data['cameraViewBehaviour'],
            teamSize: $data['teamSize'],
            isCustomGame: $data['isCustomGame'],
            isEventMode: $data['isEventMode'],
            blueZoneCustomOptions: $data['blueZoneCustomOptions'],
        );
    }
}
