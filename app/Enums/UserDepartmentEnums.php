<?php

namespace App\Enums;

enum UserDepartmentEnums:string {
    case EXO = 'Executive Office';
    case AMD = 'Admissions';
    case FBD = 'Food and Beverage';
    case HRD = 'Human Resources';
    case ITD = 'Information and Technology';
    case RTD = 'Retail';
    case FID = 'Finance and Accounting';
    case OPD = 'Operations';
    case HKD = 'Housekeeping';
    case SAD = 'Sales';
    case ENG = 'Engineering';
    case LUD = 'Laundry';
    case MKT = 'Marketing';

    case LSD = 'Learning and Development';
    case PER = 'Purchasing';
    case EVD = 'Event';

    public function initial(): string {
        return match($this)
        {
            UserDepartmentEnums::EXO => 'Executive Office',
            UserDepartmentEnums::AMD => 'Admissions',
            UserDepartmentEnums::FBD => 'Food and Beverage',
            UserDepartmentEnums::HRD => 'Human Resources',
            UserDepartmentEnums::ITD => 'Information Technology',
            UserDepartmentEnums::RTD => 'Retail',
            UserDepartmentEnums::FID => 'Finance',
            UserDepartmentEnums::OPD => 'Operations',
            UserDepartmentEnums::HKD => 'Housekeeping',
            UserDepartmentEnums::SAD => 'Sales',
            UserDepartmentEnums::ENG => 'Engineering',
            UserDepartmentEnums::LUD => 'Laundry',
            UserDepartmentEnums::MKT => 'Marketing',
            UserDepartmentEnums::LSD => 'Learning and Development',
        };
    }
}
