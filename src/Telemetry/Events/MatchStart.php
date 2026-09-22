<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\CharacterWrapper;
use Bluezone\Telemetry\Objects\Common;

class MatchStart extends TelemetryEvent
{
    public string $type = 'match start';

    public function __construct(
        public readonly string $mapName,
        public readonly string $weatherId,
        public readonly array $characters,
        public readonly string $cameraViewBehaviour,
        public readonly int $teamSize,
        public readonly bool $isCustomGame,
        public readonly bool $isEventMode,
        public readonly string $blueZoneCustomOptions,
        public readonly Common $common,
    ) {}

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
