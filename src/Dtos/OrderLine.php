<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Carbon\Carbon;
use Pdfsystems\OrderTrackSdk\Enums\OrderLineType;
use Rpungello\SdkClient\DataTransferObject;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;

class OrderLine extends DataTransferObject
{
    public int $order_id;
    public float $line_number;
    #[CastWith(EnumCaster::class, OrderLineType::class)]
    public OrderLineType $type;
    public string $item_number;
    public ?string $primary_description;
    public ?string $secondary_description;
    public ?string $unit_of_measure;
    public ?int $book_id;
    public float $price = 0;
    public float $quantity = 0;
    public float $extension = 0;
    public float $extension_discounted = 0;
    public ?string $comments;
    public ?Carbon $created_at;
    public ?Carbon $updated_at;
}
