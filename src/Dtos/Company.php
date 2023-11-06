<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class Company extends DataTransferObject
{
    public ?int $id;
    public string $name;
    public ?string $street;
    public ?string $street2;
    public ?string $city;
    public ?string $postal_code;
    public ?int $country_id;
    public ?int $state_id;
    public ?string $type;
    public ?string $customer_service_email;
    public ?string $sample_email;
    public ?int $prefix;
    public ?int $next_sample_order_number;
    public ?string $shipping_class;
}
