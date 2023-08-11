<?php

namespace Pdfsystems\OrderTrackSdk;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use Pdfsystems\OrderTrackSdk\Dtos\User;
use Pdfsystems\OrderTrackSdk\Repositories\CustomersRepository;
use Pdfsystems\OrderTrackSdk\Repositories\ProductsRepository;
use Pdfsystems\OrderTrackSdk\Repositories\SampleOrdersRepository;
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

    public function products(): ProductsRepository
    {
        return new ProductsRepository($this);
    }

    public function customers(): CustomersRepository
    {
        return new CustomersRepository($this);
    }

    public function sampleOrders(): SampleOrdersRepository
    {
        return new SampleOrdersRepository($this);
    }
}
