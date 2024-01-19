<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Carbon\Carbon;
use Rpungello\SdkClient\DataTransferObject;

class Representation extends DataTransferObject
{
    public int $distributor_id;
    public int $rep_id;
    public ?string $rep_code = null;
    public bool $allow_inventory = false;
    public bool $allow_excel = false;
    public bool $allow_sampling_restricted_products = false;
    public bool $allow_product_edit = false;
    public ?int $max_samples = null;
    public ?Carbon $created_at;
    public ?Carbon $updated_at;
}
