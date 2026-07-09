<?php

namespace App\Enums;

enum StatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case BLOCKED = 'blocked';
    case DELETED = 'deleted';
    case UNVERIFIED = 'unverified';
}
