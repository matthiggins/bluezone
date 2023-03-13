<?php

namespace Bluezone\Resources;

use Saloon\Contracts\Connector;

class Resource
{
    public function __construct(protected Connector $connector)
    {
    }
}
