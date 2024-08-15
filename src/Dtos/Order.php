<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Carbon\Carbon;
use DateTimeImmutable;
use Pdfsystems\OrderTrackSdk\Enums\OrderStatus;
use Pdfsystems\OrderTrackSdk\Enums\OrderType;
use Rpungello\SdkClient\DataTransferObject;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;

class Order extends DataTransferObject
{
    public ?int $id;
    public ?Company $distributor;
    public string $order_number;
    public DateTimeImmutable $date_entered;
    #[CastWith(EnumCaster::class, OrderStatus::class)]
    public OrderStatus $status;
    #[CastWith(EnumCaster::class, OrderType::class)]
    public OrderType $type;
    public bool $backordered = false;
    public ?DateTimeImmutable $date_shipped;
    public ?string $invoice_number;
    public ?DateTimeImmutable $date_invoiced;
    public ?int $fiscal_year;
    public ?DateTimeImmutable $date_canceled;
    public ?string $reason_canceled;
    public ?Customer $customer;
    public ?string $customer_attention;
    public ?string $customer_phone;
    public ?string $customer_email;
    public ?string $customer_order_number;
    public ?string $sidemark;
    public ?string $order_terms;
    public string $rep_code;
    public ?string $master_rep_code;
    public ?string $sub_rep_code;
    public ?string $rep_order_number;
    public ?string $ship_to_name;
    public ?string $ship_to_street;
    public ?string $ship_to_street2;
    public ?string $ship_to_city;
    public ?string $ship_to_state;
    public ?string $ship_to_postal_code;
    public ?string $ship_to_country;
    public ?string $ship_to_attention;
    public ?string $shipping_carrier;
    public ?string $shipping_method;
    public float $material_amount = 0;
    public float $discount_amount = 0;
    public float $discount_percent = 0;
    public float $service_amount = 0;
    public float $freight_amount = 0;
    public float $sales_tax = 0;
    public float $sale_amount = 0;
    public float $order_total = 0;
    public float $deposit_paid = 0;
    public ?Carbon $created_at;
    public ?Carbon $updated_at;
    /** @var OrderLine[] */
    #[CastWith(ArrayCaster::class, itemType: OrderLine::class)]
    public array $lines = [];
    /** @var TrackingNumber[] */
    #[CastWith(ArrayCaster::class, itemType: TrackingNumber::class)]
    public array $tracking_numbers = [];
    /** @var OrderHold[] */
    #[CastWith(ArrayCaster::class, itemType: OrderHold::class)]
    public array $holds = [];
}
