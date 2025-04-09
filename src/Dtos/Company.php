<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

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
    public ?int $website_rep_id;
    public ?int $website_user_id;
    public ?string $image_url;
    public ?string $barcode_pattern_products;
    public bool $display_piece_comments = false;
    public bool $display_discontinued_info = false;
    public bool $sampling_sort_description = false;
    #[CastWith(ArrayCaster::class, itemType: Service::class)]
    public array $services = [];
}
