<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class State extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $code;
}
