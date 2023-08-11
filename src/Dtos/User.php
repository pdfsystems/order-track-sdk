<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class User extends DataTransferObject
{
    public ?int $id;

    public string $name;

    public string $email;

    public bool $admin = false;

    public ?int $page_size;

    public bool $email_sample_orders = false;

    public bool $allow_direct_sample_types = false;
}
