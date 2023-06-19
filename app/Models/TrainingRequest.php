<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'req_code',
        'req_obj',
        'req_title',
        'req_status',
        'user_id',
    ];
    protected $casts = [
        'req_dateReview' => 'datetime',
        'req_dateApprove' => 'datetime',
    ];

    public static function getNewTrainNo(){
        $currentYear = Carbon::now()->year;
        $record = TrainingRequest::whereYear('created_at',$currentYear)
                        ->where('req_code','like','TRAIN%');
        $num = str_pad($record->count()+1, 4, "0", STR_PAD_LEFT);
        $reqNo = 'TRAIN'.$currentYear.$num;
        // dd($reqNo,$record);
        return $reqNo;
    }

    public static function getNewExternalNo(){
        $currentYear = Carbon::now()->year;
        $record = TrainingRequest::whereYear('created_at',$currentYear)
                        ->where('req_code','like','EXT%');
        $num = str_pad($record->count()+1, 4, "0", STR_PAD_LEFT);
        $reqNo = 'EXT'.$currentYear.$num;
        // dd($reqNo);
        return $reqNo;
    }

    public static function getMinDate(){
        $now = Carbon::now();
        $min = $now->addDays(3)->toDateString();
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
                # code...
                break;
        }
        // dd($status);
        return 'cyan';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function info(){
        return $this->hasOne(TrainingRequestInfo::class,'request_req_code','req_code');
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

}
