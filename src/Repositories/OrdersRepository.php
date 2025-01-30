<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Pdfsystems\OrderTrackSdk\Dtos\Company;
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
        #[ArrayShape(['customer' => 'int', 'customer_number' => 'string', 'customer_name' => 'string', 'order_number' => 'string', 'status' => 'string'])]
        array $params = []
    ): OrderList {
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

    /**
     * @param Order $order
     * @param string $path
     * @return void
     * @throws GuzzleException
     */
    public function downloadPdf(Order $order, string $path): void
    {
        $response = $this->client->get("/api/orders/$order->id/print");
        file_put_contents($path, $response->getBody()->getContents());
    }

    /**
     * @param string $orderNumber
     * @param string $path
     * @return void
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function downloadPdfForOrderNumber(string $orderNumber, string $path): void
    {
        $this->downloadPdf($this->findByOrderNumber($orderNumber), $path);
    }

    /**
     * @throws GuzzleException
     */
    public function import(Company|int $company, array $orders): ?array
    {
        return $this->client->putJson('api/admin/orders', [
            'team_id' => $company instanceof Company ? $company->id : $company,
            'data' => $orders,
        ]);
    }
}
