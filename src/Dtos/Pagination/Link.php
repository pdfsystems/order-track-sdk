<?php

namespace Pdfsystems\OrderTrackSdk\Dtos\Pagination;

use Spatie\DataTransferObject\DataTransferObject;

class Link extends DataTransferObject
{
    public ?string $url;
    public ?string $label;
    public bool $active;
}
