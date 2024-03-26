<?php

namespace Pdfsystems\OrderTrackSdk;

use Composer\InstalledVersions;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use OutOfBoundsException;
use Pdfsystems\OrderTrackSdk\Dtos\User;
use Pdfsystems\OrderTrackSdk\Repositories\CompaniesRepository;
use Pdfsystems\OrderTrackSdk\Repositories\CustomersRepository;
use Pdfsystems\OrderTrackSdk\Repositories\OrdersRepository;
use Pdfsystems\OrderTrackSdk\Repositories\ProductsRepository;
use Pdfsystems\OrderTrackSdk\Repositories\SampleOrdersRepository;
use Pdfsystems\OrderTrackSdk\Repositories\UsersRepository;
use Rpungello\SdkClient\SdkClient;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class OrderTrackClient extends SdkClient
{
    public function __construct(public string $authToken, public ?int $teamId = null, string $baseUri = 'https://order-track.com', HandlerStack $handler = null)
    {
        parent::__construct($baseUri, $handler, static::getUserAgent());
    }

    private static function getUserAgent(): string
    {
        return 'Order-Track SDK/' . static::getVersion();
    }

    private static function getVersion(): string
    {
        try {
            return InstalledVersions::getVersion('pdfsystems/order-track-sdk');
        } catch (OutOfBoundsException) {
            return InstalledVersions::getRootPackage()['version'];
        }
    }

    protected function getGuzzleClientConfig(): array
    {
        $config = parent::getGuzzleClientConfig();
        $config['headers']['authorization'] = "Bearer $this->authToken";

        if (! empty($this->teamId)) {
            $config['headers']['x-team-id'] = $this->teamId;
        }

        return $config;
    }

    /**
     * @return User
     * @throws GuzzleException
     * @throws UnknownProperties
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

    public function orders(): OrdersRepository
    {
        return new OrdersRepository($this);
    }

    public function sampleOrders(): SampleOrdersRepository
    {
        return new SampleOrdersRepository($this);
    }

    public function companies(): CompaniesRepository
    {
        return new CompaniesRepository($this);
    }

    public function users(): UsersRepository
    {
        return new UsersRepository($this);
    }
}
