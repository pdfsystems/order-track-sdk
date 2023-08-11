<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class Company extends DataTransferObject
{
    public ?int $id;
    public string $name;
}
