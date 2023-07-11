<?php 

namespace App\Enums;

enum DocumentObjective:int {
    case NEW = 1;
    case EDIT = 2;
    case CANCLE = 3;
    case DISTROYDATA = 4;
    case COPY = 5;
    case EXTRENAL = 6;
    case RECORD = 7;


    public function discription(): string {
        return match($this)
        {
            DocumentObjective::NEW => "ขอออกเอกสารใหม่ - New Registration/Document",
            DocumentObjective::EDIT => "ขอเปลี่ยนแปลง/แก้ไขเอกสาร - Revision",
            DocumentObjective::CANCLE => "ขอยกเลิก - Canclation",
            DocumentObjective::DISTROYDATA => "ขอทำลายบันทึกเอกสาร - Destruction",
            DocumentObjective::COPY => "ขอสำเนาเอกสารเพิ่มเติม - Additional Copy",
            DocumentObjective::EXTRENAL => "ขอนำเอกสารภายนอกเข้าระบบ - Register for External Document",
            DocumentObjective::RECORD => "บีนทึกเอกสาร - Records",

        };
    }
}
