<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class SampleType extends DataTransferObject
{
    public string $name;
    public string $code;
    public bool $default = false;
}
