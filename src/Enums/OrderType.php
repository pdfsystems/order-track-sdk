<?php

namespace Pdfsystems\OrderTrackSdk\Enums;

enum OrderType: string
{
    case Order = 'order';
    case Reserve = 'reserve';
    case Quote = 'quote';
    case Sample = 'sample';
    case CreditMemo = 'credit_memo';
    case DebitMemo = 'debit_memo';
}
