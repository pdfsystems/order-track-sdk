<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use DateTimeImmutable;
use Rpungello\SdkClient\DataTransferObject;

class Inventory extends DataTransferObject
{
    public ?int $distributor_id;
    public string $item_number;
    public ?string $lot_number;
    public ?string $piece_number;
    public ?DateTimeImmutable $date_received;
    public ?string $warehouse;
    public ?string $warehouse_location;
    public ?string $comment;
    public float $quantity_on_hand = 0;
    public float $quantity_available = 0;
}
