<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum ClientStatusEnum: int
{
    use EnumTrait;

    case ACTIVE = 1;

    case INACTIVE = 0;
}
