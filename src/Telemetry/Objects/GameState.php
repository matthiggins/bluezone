<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Objects;

class GameState
{
    public function __construct(
        readonly public int $elapsedTime,
        readonly public int $numAliveTeams,
        readonly public int $numJoinPlayers,
        readonly public int $numStartPlayers,
        readonly public int $numAlivePlayers,
        readonly public Location|null $safeZonePosition,
        readonly public float|null $safeZoneRadius,
        readonly public Location $poisonGasWarningPosition,
        readonly public float $poisonGasWarningRadius,
        readonly public Location $redZonePosition,
        readonly public float $redZoneRadius,
        readonly public Location $blackZonePosition,
        readonly public float $blackZoneRadius,

    ) {
    }

    public static function make(array $data): self
    {
        return new static(
            elapsedTime: $data['elapsedTime'],
            numAliveTeams: $data['numAliveTeams'],
            numJoinPlayers: $data['numJoinPlayers'],
            numStartPlayers: $data['numStartPlayers'],
            numAlivePlayers: $data['numAlivePlayers'],
            safeZonePosition: isset($data['safeZonePosition']) ? Location::make($data['safeZonePosition']) : null,
            safeZoneRadius: $data['safeZoneRadius'] ?? null,
            poisonGasWarningPosition: Location::make($data['poisonGasWarningPosition']),
            poisonGasWarningRadius: $data['poisonGasWarningRadius'],
            redZonePosition: Location::make($data['redZonePosition']),
            redZoneRadius: $data['redZoneRadius'],
            blackZonePosition: Location::make($data['blackZonePosition']),
            blackZoneRadius: $data['blackZoneRadius'],
        );
    }
}
