<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum IssueStateEnum: string
{
    use EnumTrait;

    case OPENED = 'opened';
    case CLOSED = 'closed';
}
