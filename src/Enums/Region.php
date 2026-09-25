<?php

declare(strict_types=1);

namespace Bluezone\Enums;

/** Platform-region shards; only the leaderboards still take one, every other endpoint takes a Shard. */
enum Region: string
{
    case PcAs = 'pc-as';
    case PcEu = 'pc-eu';
    case PcJp = 'pc-jp';
    case PcKakao = 'pc-kakao';
    case PcKrjp = 'pc-krjp';
    case PcNa = 'pc-na';
    case PcOc = 'pc-oc';
    case PcRu = 'pc-ru';
    case PcSa = 'pc-sa';
    case PcSea = 'pc-sea';
    case PsnAs = 'psn-as';
    case PsnEu = 'psn-eu';
    case PsnNa = 'psn-na';
    case PsnOc = 'psn-oc';
    case XboxAs = 'xbox-as';
    case XboxEu = 'xbox-eu';
    case XboxNa = 'xbox-na';
    case XboxOc = 'xbox-oc';
    case XboxSa = 'xbox-sa';

    public static function resolve(self|string $region): self
    {
        return $region instanceof self ? $region : self::from($region);
    }
}
