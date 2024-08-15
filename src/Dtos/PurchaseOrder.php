<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use DateTimeImmutable;
use Rpungello\SdkClient\DataTransferObject;

class PurchaseOrder extends DataTransferObject
{
    public ?int $distributor_id;
    public string $item_number;
    public string $purchase_order_number;
    public ?string $line_number;
    public ?DateTimeImmutable $date_due;
    public ?string $comment;
    public ?string $confirmation_number;
    public float $quantity_ordered = 0;
    public float $quantity_available = 0;
}
