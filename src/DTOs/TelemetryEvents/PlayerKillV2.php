<?php

declare(strict_types=1);

namespace Bluezone\DTOs\TelemetryEvents;

use Bluezone\DTOs\TelemetryObjects\Character;
use Bluezone\DTOs\TelemetryObjects\Common;
use Bluezone\DTOs\TelemetryObjects\DamageInfo;
use Bluezone\DTOs\TelemetryObjects\GameResult;

class PlayerKillV2 extends AbstractEventDTO
{
    public string $type = 'player kill';

    public function __construct(
        readonly public int $attackId,
        readonly public int $dBNOId,
        readonly public GameResult $victimGameResult,
        readonly public Character $victim,
        readonly public string $victimWeapon,
        readonly public array $victimWeaponAdditionalInfo,
        readonly public Character|null $dBNOMaker,
        readonly public DamageInfo|null $dBNODamageInfo,
        readonly public Character|null $finisher,
        readonly public DamageInfo $finishDamageInfo,
        readonly public Character|null $killer,
        readonly public DamageInfo $killerDamageInfo,
        readonly public array $assists_AccountId,
        readonly public array $teamKillers_AccountId,
        readonly public bool $isSuicide,
        readonly public Common $common,
    ) {
    }

    public static function fromEvent(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            dBNOId: $data['dBNOId'],
            victimGameResult: GameResult::fromEvent($data['victimGameResult']),
            victim: Character::fromEvent($data['victim']),
            victimWeapon: $data['victimWeapon'],
            victimWeaponAdditionalInfo: $data['victimWeaponAdditionalInfo'],
            dBNOMaker: isset($data['DBNOMaker']) ? Character::fromEvent($data['DBNOMaker']) : null,
            dBNODamageInfo: isset($data['DBNODamageInfo']) ? DamageInfo::fromEvent($data['DBNODamageInfo']) : null,
            finisher: isset($data['finisher']) ? Character::fromEvent($data['finisher']) : null,
            finishDamageInfo: DamageInfo::fromEvent($data['finishDamageInfo']),
            killer: isset($data['killer']) ? Character::fromEvent($data['killer']) : null,
            killerDamageInfo: DamageInfo::fromEvent($data['killerDamageInfo']),
            assists_AccountId: $data['assists_AccountId'],
            teamKillers_AccountId: $data['teamKillers_AccountId'],
            isSuicide: $data['isSuicide'],
            common: Common::fromEvent($data['common']),
        );
    }
}
