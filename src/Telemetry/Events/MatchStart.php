<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\CharacterWrapper;
use Bluezone\Telemetry\Objects\Common;

class MatchStart extends TelemetryEvent
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
        readonly public Common $common,
    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            mapName: $data['mapName'],
            weatherId: $data['weatherId'],
            characters: array_map(fn ($character) => CharacterWrapper::make($character), $data['characters']),
            cameraViewBehaviour: $data['cameraViewBehaviour'],
            teamSize: $data['teamSize'],
            isCustomGame: $data['isCustomGame'],
            isEventMode: $data['isEventMode'],
            blueZoneCustomOptions: $data['blueZoneCustomOptions'],
            common: Common::make($data['common']),
        );
    }
}
