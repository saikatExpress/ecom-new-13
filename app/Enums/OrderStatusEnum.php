<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    const NEW_ORDER        = 1;
    const APPROVED         = 2;
    const INVOICED         = 3;
    const IN_COURIER       = 4;
    const ON_HOLD          = 5;
    const STOCK_PENDING    = 6;
    const DELIVERED        = 7;
    const CANCELED         = 8;
    const PENDING_RETURNED = 9;
    const RETURNED         = 10;
    const DAMAGED          = 11;
    const PARTIAL_RETURNED = 12;
    const COURIER_PENDING  = 13;
    const COURIER_RECEIVED = 14;
}
