<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class Country extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $code;
    public int $priority;
}
