<?php

namespace Pdfsystems\OrderTrackSdk;

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
    /**
     * @return User
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
