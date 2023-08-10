<?php

namespace Pdfsystems\OrderTrackSdk;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use Pdfsystems\OrderTrackSdk\Dtos\User;
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
        $config['headers']['accept'] = 'application/json';

        return $config;
    }

    /**
     * @return User
     * @throws GuzzleException
     */
    public function getAccount(): User
    {
        return $this->getDto('api/user', User::class);
    }
}
