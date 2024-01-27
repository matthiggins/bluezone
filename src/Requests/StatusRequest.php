<?php

declare(strict_types=1);

namespace Bluezone\Requests;

use Bluezone\Responses\Status;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\HasConnector;

class StatusRequest extends Request
{
    use HasConnector;

    protected Method $method = Method::GET;

    public function __construct() {
    }

    public function resolveEndpoint(): string
    {
        return 'status';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Status::make(
            response: $response
        );
    }
}
