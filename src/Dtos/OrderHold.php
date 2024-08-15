<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class OrderHold extends DataTransferObject
{
    public int $order_id;
    public string $code;
    public string $description;
}
