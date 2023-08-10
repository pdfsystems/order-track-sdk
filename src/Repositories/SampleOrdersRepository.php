<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use Pdfsystems\OrderTrackSdk\Dtos\Pagination\SampleOrderList;
use Pdfsystems\OrderTrackSdk\Repositories\Repository;

class SampleOrdersRepository extends Repository
{
    public function search(int $teamId, int $perPage = 15, int $page = 1, array $params = []): SampleOrderList
    {
        return $this->client->getDto('api/sample-orders', SampleOrderList::class, array_merge($params, [
            'team' => $teamId,
            'count' => $perPage,
            'page' => $page,
        ]));
    }
}
