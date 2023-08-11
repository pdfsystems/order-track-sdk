<?php

namespace Pdfsystems\OrderTrackSdk\Dtos\Pagination;

use Pdfsystems\OrderTrackSdk\Dtos\Order;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class OrderList extends PaginatedResult
{
    /** @var Order[] */
    #[CastWith(ArrayCaster::class, itemType: Order::class)]
    public array $data;
}
