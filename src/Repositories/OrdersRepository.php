<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Pdfsystems\OrderTrackSdk\Dtos\Order;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\OrderList;
use Pdfsystems\OrderTrackSdk\Exceptions\NotFoundException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class OrdersRepository extends Repository
{
    /**
     * @param int $perPage
     * @param int $page
     * @param array $params
     * @return OrderList
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function search(
        int $perPage = 15,
        int $page = 1,
        #[ArrayShape(['customer' => 'int', 'customer_number' => 'string', ])]
        array $params = []
    ): OrderList
    {
        return $this->client->getDto('api/orders', OrderList::class, array_merge($params, [
            'count' => $perPage,
            'page' => $page,
        ]));
    }

    /**
     * @param string $orderNumber
     * @return Order
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function findByOrderNumber(string $orderNumber): Order
    {
        $results = $this->search(1, 1, [
            'order_number' => $orderNumber,
        ]);

        if ($results->total > 0) {
            return $results->data[0];
        } else {
            throw new NotFoundException("Order with order number $orderNumber not found");
        }
    }
}
