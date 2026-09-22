<?php

declare(strict_types=1);

namespace Bluezone\Resources;

use Bluezone\Requests\TelemetryDownloadRequest;
use Bluezone\Responses\Telemetry;
use Psr\Http\Message\StreamInterface;
use Saloon\Http\BaseResource;

final class TelemetryResource extends BaseResource
{
    /** The gzip-compressed body as a PSR stream; copy it straight to disk, nothing is decoded here. */
    public function download(string $url): StreamInterface
    {
        return $this->connector->send(new TelemetryDownloadRequest($url))->stream();
    }

    /** The decoded telemetry as a DTO; reads the whole file into memory, so not for parsing at scale. */
    public function fetch(string $url): Telemetry
    {
        $body = (string) $this->download($url);
        $decoded = self::isGzip($body) ? (string) gzdecode($body) : $body;

        return Telemetry::fromJson($decoded);
    }

    private static function isGzip(string $bytes): bool
    {
        return str_starts_with($bytes, "\x1f\x8b");
    }
}
