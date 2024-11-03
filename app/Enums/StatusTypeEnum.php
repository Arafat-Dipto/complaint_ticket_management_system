<?php

namespace App\Enums;

enum StatusTypeEnum: string {
    case Open       = 'Open';
    case InProgress = 'In Progress';
    case Resolved   = 'Resolved';
    case Closed     = 'Closed';
}
