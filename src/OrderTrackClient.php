<?php

namespace Pdfsystems\OrderTrackSdk;

use GuzzleHttp\HandlerStack;
use Rpungello\SdkClient\SdkClient;

class OrderTrackClient extends SdkClient
{
    public function __construct(public string $authToken, string $baseUri = 'https://order-track.com', HandlerStack $handler = null)
    {
        parent::__construct($baseUri, $handler);
    }

    protected function getGuzzleClientConfig(): array
    {
        $config = parent::getGuzzleClientConfig();
        $config['headers']['authorization'] = "Bearer $this->authToken";

        return $config;
    }
}
