<?php

declare(strict_types=1);

namespace Bluezone\Telemetry\Events;

use Bluezone\Telemetry\Objects\Character;
use Bluezone\Telemetry\Objects\Common;
use Bluezone\Telemetry\Objects\DamageInfo;
use Bluezone\Telemetry\Objects\GameResult;

class PlayerKillV2 extends TelemetryEvent
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

    public static function make(array $data): self
    {
        return new static(
            attackId: $data['attackId'],
            dBNOId: $data['dBNOId'],
            victimGameResult: GameResult::make($data['victimGameResult']),
            victim: Character::make($data['victim']),
            victimWeapon: $data['victimWeapon'],
            victimWeaponAdditionalInfo: $data['victimWeaponAdditionalInfo'],
            dBNOMaker: isset($data['DBNOMaker']) ? Character::make($data['DBNOMaker']) : null,
            dBNODamageInfo: isset($data['DBNODamageInfo']) ? DamageInfo::make($data['DBNODamageInfo']) : null,
            finisher: isset($data['finisher']) ? Character::make($data['finisher']) : null,
            finishDamageInfo: DamageInfo::make($data['finishDamageInfo']),
            killer: isset($data['killer']) ? Character::make($data['killer']) : null,
            killerDamageInfo: DamageInfo::make($data['killerDamageInfo']),
            assists_AccountId: $data['assists_AccountId'],
            teamKillers_AccountId: $data['teamKillers_AccountId'],
            isSuicide: $data['isSuicide'],
            common: Common::make($data['common']),
        );
    }
}
