<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\ProductList;
use Pdfsystems\OrderTrackSdk\Dtos\Product;
use Pdfsystems\OrderTrackSdk\Exceptions\NotFoundException;

class ProductsRepository extends Repository
{
    /**
     * Searches all products for a given distributor
     *
     * @param int $distributorId
     * @param int $perPage
     * @param int $page
     * @param array $params
     * @return ProductList
     * @throws GuzzleException
     */
    public function search(int $distributorId, int $perPage = 15, int $page = 1, array $params = []): ProductList
    {
        return $this->client->getDto('api/products', ProductList::class, array_merge($params, [
                'team' => $distributorId,
                'count' => $perPage,
                'page' => $page,
            ]));
    }

    /**
     * Loads a distributor's product by its item number
     *
     * @param int $distributorId
     * @param string $itemNumber
     * @return Product
     * @throws GuzzleException
     */
    public function findByItemNumber(int $distributorId, string $itemNumber): Product
    {
        $results = $this->search($distributorId, 1, 1, [
            'item_number' => $itemNumber,
        ]);

        if ($results->total > 0) {
            return $results->data[0];
        } else {
            throw new NotFoundException("Product with item number $itemNumber not found for team $distributorId");
        }
    }
}
