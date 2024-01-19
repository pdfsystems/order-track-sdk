<?php

namespace Pdfsystems\OrderTrackSdk\Dtos;

use Rpungello\SdkClient\DataTransferObject;

class Membership extends DataTransferObject
{
    public int $team_id;

    public int $user_id;

    public ?string $role;
}
