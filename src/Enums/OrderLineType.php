<?php

namespace Pdfsystems\OrderTrackSdk\Enums;

enum OrderLineType: int
{
    case Item = 0;
    case Service = 1;
    case Comment = 2;
}
