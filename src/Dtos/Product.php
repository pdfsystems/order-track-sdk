<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use DateTimeImmutable;
use Rpungello\SdkClient\Casters\DateTimeCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class Product extends DataTransferObject
{
    public ?int $id;
    public string $item_number;
    public string $style_name;
    public ?string $color_name;
    #[CastWith(DateTimeCaster::class)]
    public ?DateTimeImmutable $date_introduced;
    public ?string $product_category;
    public ?string $primary_color;
    public ?string $secondary_color;
    public ?string $unit_of_measure;
    public bool $book = false;
    public bool $book_current = false;
    public ?string $collection_name;
    public ?string $freight_code;
    public ?string $design_description;
    public ?string $content_description;
    public ?string $misc_description;
    public ?string $content;
    public ?string $width;
    public ?string $repeat;
    public ?float $weight_ounce;
    public ?float $yardage_factor;
    public float $price = 0;
    public ?string $country;
    public ?string $finish;
    public ?string $label_message;
    public ?string $tests;
    public ?string $style_comment;
    public ?string $item_comment;
    public ?string $web_comment;
    public ?string $image_url;
    public ?string $discontinued_reason;
    #[CastWith(DateTimeCaster::class)]
    public ?DateTimeImmutable $discontinued_date;
}
