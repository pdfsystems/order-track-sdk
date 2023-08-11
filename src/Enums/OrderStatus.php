<?php

namespace Pdfsystems\OrderTrackSdk\Enums;

enum OrderStatus: string
{
    case Open = 'open';
    case Shipped = 'shipped';
    case Canceled = 'canceled';
}
