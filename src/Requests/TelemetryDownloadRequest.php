<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Exceptions\InvalidTelemetryUrlException;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/** Streams the raw, still-gzipped body so callers can archive it without decoding it in memory. */
final class TelemetryDownloadRequest extends Request
{
    protected Method $method = Method::GET;

    private string $path;

    public function __construct(string $url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        $path = parse_url($url, PHP_URL_PATH);

        if ($host !== 'telemetry-cdn.pubg.com' || ! is_string($path) || $path === '') {
            throw InvalidTelemetryUrlException::forUrl($url);
        }

        $this->path = $path;
    }

    public function resolveEndpoint(): string
    {
        return $this->path;
    }

    /** @return array<string, string> */
    protected function defaultHeaders(): array
    {
        return ['Accept-Encoding' => 'gzip'];
    }

    /** @return array<string, mixed> */
    protected function defaultConfig(): array
    {
        return ['stream' => true, 'decode_content' => false];
    }
}
