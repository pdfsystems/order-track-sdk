<?php

namespace Pdfsystems\OrderTrackSdk\Dtos\Pagination;

use Pdfsystems\OrderTrackSdk\Dtos\SampleOrder;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class SampleOrderList extends PaginatedResult
{
    /** @var SampleOrder[] */
    #[CastWith(ArrayCaster::class, itemType: SampleOrder::class)]
    public array $data;
}
