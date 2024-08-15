<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class TrackingNumber extends DataTransferObject
{
    public ?int $id;
    public int $order_id;
    public string $tracking_number;
    public ?string $tracking_url;
}
