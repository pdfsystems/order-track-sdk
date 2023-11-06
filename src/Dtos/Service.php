<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class Service extends DataTransferObject
{
    public ?int $id;
    public string $service;
    public ?array $data;
}
