<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\SampleOrderList;
use Pdfsystems\OrderTrackSdk\Dtos\SampleOrder;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SampleOrdersRepository extends Repository
{
    /**
     * @param int $perPage
     * @param int $page
     * @param array $params
     * @return SampleOrderList
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function search(
        int $perPage = 15,
        int $page = 1,
        #[ArrayShape(['shippable_items' => 'string[]', 'start_date' => 'string', 'end_date' => 'string'])]
        array $params = []
    ): SampleOrderList
    {
        return $this->client->getDto('api/sample-orders', SampleOrderList::class, array_merge($params, [
            'count' => $perPage,
            'page' => $page,
        ]));
    }

    /**
     * @param SampleOrder $order
     * @return SampleOrder
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function create(SampleOrder $order): SampleOrder
    {
        return $this->client->postDto('api/sample-orders', $order);
    }
}
