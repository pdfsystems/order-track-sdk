<?php

namespace Pdfsystems\OrderTrackSdk\Dtos\Pagination;

use Pdfsystems\OrderTrackSdk\Dtos\Customer;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class CustomerList extends PaginatedResult
{
    /** @var Customer[] */
    #[CastWith(ArrayCaster::class, itemType: Customer::class)]
    public array $data;
}
