<?php

namespace App\Enums;

enum DocumentStatusEnums:int {
    case Publish = 1;
    case Achived = 0;
    case Deleted = -1;
    case Schdule = 2;
}
