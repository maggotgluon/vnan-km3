<?php

namespace App\Models;

use App\Enums\DocumentObjective;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'req_code',
        'req_obj',
        'req_title',
        'req_status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function info(){
        return $this->hasOne(DocumentRequestInfo::class,'request_req_code','req_code');
    }

    protected $casts = [
        'req_dateReview' => 'datetime',
        'req_dateApprove' => 'datetime',
        'req_obj' => DocumentObjective::class,
    ];
    public static function getNewDarNo(){
        $currentYear = Carbon::now()->year;
        $record = DocumentRequest::whereYear('created_at',$currentYear)
                        ->where('req_code','like','DAR%');
        $num = str_pad($record->count()+1, 4, "0", STR_PAD_LEFT);
        $reqNo = 'DAR'.$currentYear.$num;
        // dd($reqNo,$record);
        return $reqNo;
    }
    public static function getNewRecordNo(){
        $currentYear = Carbon::now()->year;
        $record = DocumentRequest::whereYear('created_at',$currentYear)
                        ->where('req_code','like','REC%');
        $num = str_pad($record->count()+1, 4, "0", STR_PAD_LEFT);
        $reqNo = 'REC'.$currentYear.$num;
        // dd($reqNo,$record);
        return $reqNo;
    }
    public static function getMinDate(){
        $now = Carbon::now();
        $min = $now->addDays(10)->toDateString();
        return $min;
    }
    public function getColor($type=null){
        $status = $this->req_status;
        switch ($status) {
            case '-2':
                return 'negative';
                break;
            case '-1':
                return 'negative';
                break;
            case '0':
                return 'neutral';
                break;
            case '1':
                return 'slate';
                break;
            case '2':
                return 'info';
                break;
            case '3':
                return 'positive';
                break;
            default:
                return 'cyan';
                break;
        }
        // dd($status);
        return 'cyan';
    }
    public function getStatus(){
        switch ($this->req_status) {
            case 0:
                return 'Draft';
                break;
            case 1:
                return 'Pending';
                break;
            case 2:
                return 'Reviewed';
                break;
            case 3:
                return 'Approved';
                break;
            case -1:
                return 'Reject';
                break;
            case -2:
                return 'Deleted';
                break;
            default:
                return 'Unknow';
                break;
        }
    }
    public function getObjective(){

        switch ($this->req_obj) {
            case 0:
                break;
            case 1:
                return 'ขอออกเอกสารใหม่ - New Registration/Document';
                break;
            case 2:
                return 'ขอเปลี่ยนแปลง/แก้ไขเอกสาร - Revision';
                break;
            case 3:
                return 'ขอยกเลิก - Canclation';
                break;
            case 4:
                return 'ขอทำลายบันทึกเอกสาร - Destruction';
                break;
            case 5:
                return 'ขอสำเนาเอกสารเพิ่มเติม - Additional Copy';
                break;
            case 6:
                return 'ขอนำเอกสารภายนอกเข้าระบบ - Register for External Document';
                break;
            case 7:
                return 'บีนทึกเอกสาร - Records';
                break;
            default:
                break;
        }
    }
}
