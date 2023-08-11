<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\OrderTrackSdk\Dtos\Customer;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\CustomerList;
use Pdfsystems\OrderTrackSdk\Exceptions\NotFoundException;

class CustomersRepository extends Repository
{
    /**
     * Searches all customers for a given distributor
     *
     * @param int $distributorId
     * @param int $perPage
     * @param int $page
     * @param array $params
     * @return CustomerList
     * @throws GuzzleException
     */
    public function search(int $distributorId, int $perPage = 15, int $page = 1, array $params = []): CustomerList
    {
        return $this->client->getDto('api/customers', CustomerList::class, array_merge($params, [
                'team' => $distributorId,
                'count' => $perPage,
                'page' => $page,
            ]));
    }

    /**
     * Loads a distributor's customer by its item number
     *
     * @param int $distributorId
     * @param string $customerNumber
     * @return Customer
     * @throws GuzzleException
     */
    public function findByCustomerNumber(int $distributorId, string $customerNumber): Customer
    {
        $results = $this->search($distributorId, 1, 1, [
            'customer_number' => $customerNumber,
        ]);

        if ($results->total > 0) {
            return $results->data[0];
        } else {
            throw new NotFoundException("Customer with customer number $customerNumber not found for team $distributorId");
        }
    }
}
