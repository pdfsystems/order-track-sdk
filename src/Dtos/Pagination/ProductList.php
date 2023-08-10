<?php

namespace Pdfsystems\OrderTrackSdk\Dtos\Pagination;

use Pdfsystems\OrderTrackSdk\Dtos\Product;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class ProductList extends PaginatedResult
{
    /** @var Product[] */
    #[CastWith(ArrayCaster::class, itemType: Product::class)]
    public array $data;
}
