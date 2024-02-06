<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class SampleType extends DataTransferObject
{
    public string $name;
    public ?string $code;
    public bool $default = false;
}
