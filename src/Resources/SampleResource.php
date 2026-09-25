<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Enums\Shard;
use Bluezone\Requests\SamplesRequest;
use Bluezone\Responses\Samples;
use DateTimeInterface;

class SampleResource extends Resource
{
    /** A random sample of recent match ids; without `$since` PUBG samples the last 24 hours. */
    public function get(Shard|string $shard, ?DateTimeInterface $since = null): Samples
    {
        return $this->send(new SamplesRequest(
            shard: Shard::resolve($shard),
            since: $since,
        ), Samples::class);
    }
}
