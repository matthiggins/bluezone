<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Enums\Shard;
use Bluezone\Exceptions\InvalidSampleWindowException;
use Bluezone\Requests\SamplesRequest;
use Bluezone\Responses\Samples;
use Carbon\Carbon;
use DateTimeInterface;

class SampleResource extends Resource
{
    /** A random sample of recent match ids; without `$since` PUBG samples the last 24 hours. */
    public function get(Shard|string $shard, ?DateTimeInterface $since = null): Samples
    {
        // Checked here so a bad window costs no rate-limited request.
        if ($since !== null && $since < Carbon::now()->subDays(14)) {
            throw InvalidSampleWindowException::tooOld($since);
        }

        if ($since !== null && $since > Carbon::now()) {
            throw InvalidSampleWindowException::inFuture($since);
        }

        return $this->send(new SamplesRequest(
            shard: Shard::resolve($shard),
            since: $since,
        ), Samples::class);
    }
}
