<?php

namespace App\Enums;

enum TimeUnitEnum: string
{
    case MINUTE = 'minute';

    case HOUR = 'hour';

    case DAY = 'day';

    case WEEK = 'week';
}