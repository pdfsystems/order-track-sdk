<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use Pdfsystems\OrderTrackSdk\OrderTrackClient;

class Repository
{
    public function __construct(protected OrderTrackClient $client)
    {
    }
}
