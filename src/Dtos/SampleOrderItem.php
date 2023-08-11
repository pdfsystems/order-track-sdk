<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use DateTimeImmutable;
use Rpungello\SdkClient\DataTransferObject;

class SampleOrderItem extends DataTransferObject
{
    public ?int $id;
    public string $item_number;
    public ?string $style_name;
    public ?string $color_name;
    public string $status = 'open';
    public SampleType $sample_type;
    public int $quantity_ordered = 0;
    public int $quantity_shipped = 0;
    public ?DateTimeImmutable $date_pick_ticketed;
    public ?DateTimeImmutable $date_shipped;
    public ?string $tracking_number;
    public ?string $shipping_carrier;
    public ?string $shipping_method;
    public ?string $shipping_comments;
}
