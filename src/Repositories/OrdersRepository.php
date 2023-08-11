<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use Pdfsystems\OrderTrackSdk\Dtos\Order;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\OrderList;
use Pdfsystems\OrderTrackSdk\Exceptions\NotFoundException;

class OrdersRepository extends Repository
{
    public function search(int $teamId, int $perPage = 15, int $page = 1, array $params = []): OrderList
    {
        return $this->client->getDto('api/orders', OrderList::class, array_merge($params, [
            'team' => $teamId,
            'count' => $perPage,
            'page' => $page,
        ]));
    }

    public function findByOrderNumber(int $distributorId, string $orderNumber): Order
    {
        $results = $this->search($distributorId, 1, 1, [
            'order_number' => $orderNumber,
        ]);

        if ($results->total > 0) {
            return $results->data[0];
        } else {
            throw new NotFoundException("Order with order number $orderNumber not found for team $distributorId");
        }
    }
}
