<?php

namespace App\Enums;

enum UserLevelEnums:string {
    case User = '1';
    case Requester = '2';
    case Acknowledgment = '3';
    case ReviewerTraining = '4';
    case ApproverTraining = '5';
    case ReviewerDCC = '6';
    case ApproverDCC = '7';
    case Resign = '-1';
    case Other = '0';
    case SuperAdmin = '99';
}
