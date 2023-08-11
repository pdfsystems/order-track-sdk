<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class Country extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $code;
    public int $priority;
}
