<?php

namespace App\Enums;

enum RequestStatusEnums:string {
    case DRAFT = 'Draft';
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case REMOVED = 'Removed';
}
