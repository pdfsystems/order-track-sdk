<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class State extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $code;
}
