<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use DateTimeImmutable;
use Rpungello\SdkClient\Casters\DateTimeCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class Customer extends DataTransferObject
{
    public ?int $id;
    public ?Company $team;
    public ?Customer $parent;
    public ?string $customer_number;
    public string $name;
    public ?string $attention;
    public ?string $street;
    public ?string $street2;
    public ?string $city;
    public ?string $state;
    public ?string $postal_code;
    public ?string $country;
    public ?string $email;
    public ?string $phone;
    public ?string $rep_code;
    public ?string $master_rep_code;
    public ?string $sub_rep_code;
    #[CastWith(DateTimeCaster::class)]
    public ?DateTimeImmutable $date_last_sale;
    public float $sales_year_to_date = 0;
    public float $sales_previous_year = 0;
    public float $sales_two_years_ago = 0;
    public float $discount_percent = 0;
    public ?float $latitude;
    public ?float $longitude;
    #[CastWith(DateTimeCaster::class)]
    public ?DateTimeImmutable $created_at;
}
