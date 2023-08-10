<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\ProductList;

class ProductsRepository extends Repository
{
    /**
     * @param int $teamId
     * @param int $perPage
     * @param int $page
     * @param array $params
     * @return ProductList
     * @throws GuzzleException
     */
    public function search(int $teamId, int $perPage = 15, int $page = 1, array $params = []): ProductList
    {
        return $this->client->getDto('api/products', ProductList::class, array_merge($params, [
                'team' => $teamId,
                'count' => $perPage,
                'page' => $page,
            ]));
    }
}
