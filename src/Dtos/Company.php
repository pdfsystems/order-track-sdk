<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class Company extends DataTransferObject
{
    public ?int $id;
    public string $name;
}
