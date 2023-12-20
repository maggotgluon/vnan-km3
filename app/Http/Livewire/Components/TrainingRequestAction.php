<?php

namespace App\Http\Livewire\Components;

use App\Jobs\SendEmailTraining as SendEmail;
use App\Models\TrainingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use WireUi\Traits\Actions;
use Livewire\Component;

class TrainingRequestAction extends Component
{
    use Actions;

    public $req ,$code;
    public $remark,$comment;

    protected $rules = [
        'comment' => 'required|min:6',
    ];

    protected $messages = [
        'comment.required' => 'จำเป็นต้องใส่',
        'comment.min' => 'อย่างน้อย 6 ตัวอักษร',
    ];

    public function mount($code){
        $this->code = $code;
        $this->req = TrainingRequest::firstWhere('req_code',$code);
    }
    public function sendEmailAcknowledgment(){
        // dd($this->code);
        // dd(Auth::user()->user_level,Auth::user()->acknowledgment());
        // dd(Arr::pluck(Auth::user()->acknowledgment()->toArray(),'email'));
        // Mail::to(Arr::pluck(Auth::user()->acknowledgment()->toArray(),'email'))->send(new TestMail($this->req_id));
        // dd(Auth::user()->acknowledgment());
        $email = array();
        foreach (Auth::user()->acknowledgment() as $key => $value) {
            array_push($email, $value->email);
        }
        // dd($email);
        $details = [
            'email' => $email, //Arr::pluck(Auth::user()->acknowledgment()->toArray(),
            'data'=>$this->code
        ];
        // dd($details);
        SendEmail::dispatch($details);
    }
    public function updateStatus($status){
        // dd($this->req);
        $this->req->req_status = $status;
        if($status === 2){
            $this->req->req_dateReview = now();
            $this->req->user_review = auth()->user()->id;
            if($this->req->req_obj == 'external'){
                $status=3;
                $this->req->req_status = $status;
            }
        }
        if($status === 3){
            $this->req->req_dateApprove = now();
            $this->req->user_approve = auth()->user()->id;
        }
        if($this->comment){
            $this->req->remark = auth()->user()->name.' : '.$this->comment;
        }

        // dd($this->req);
        $this->req->save();
        Log::channel('training_log')->info(Auth::user()->name.' update '.$this->req->req_id.' status '.$status.' data : '.$this->req);
        $this->emitUp('actionUpdate');
    }

    public function cancel(){
        $this->resetExcept('code');
        // dd('cancle',$this->code);
    }
    public function delete(){
        // $this->req->req_status = -2;
        $this->dialog()->confirm([
            'title'       => 'ต้องการยืนยันการลบ',
            'description' => 'การดำเนินการนี้ไม่สามารถกู้คืนได้',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'ยืนยัน',
                'method' => 'updateStatus',
                'params' => -2,
            ],
            'reject' => [
                'label'  => 'ยกเลิก',
                'method' => 'cancel',
            ],
        ]);
    }
    public function edit(){
        // redirect(route('training.request.edit',['id'=>$this->req->req_code]));
        $this->req->req_status = 1;
        $this->req->save();
        $this->emitUp('actionUpdate');
    }
    public function approve(){
        // $this->req->req_status = 3;
        $this->dialog()->confirm([
            'title'       => 'ต้องการยืนยันการ ขึ้นทะเบียน '.$this->req->req_code,
            'description' => 'เรื่อง '.$this->req->req_title,
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'ยืนยัน',
                'method' => 'updateStatus',
                'params' => 3,
            ],
            'reject' => [
                'label'  => 'ยกเลิก',
                'method' => 'cancel',
            ],
        ]);
    }
    public function reject(){
        $comment = $this->validate();
        $this->remark=false;
        $this->req->req_title=$this->comment;
        $this->dialog()->confirm([
            'title'       => 'ต้องการยืนยันการ ปฎิเศษ '.$this->req->req_code ,
            'description' => 'ด้วยเหตุผลว่า : '.$this->comment,
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'ยืนยัน',
                'method' => 'updateStatus',
                'params' => -1,
            ],
            'reject' => [
                'label'  => 'ยกเลิก',
                'method' => 'cancel',
            ],
        ]);
    }
    public function review(){
        $this->dialog()->confirm([
            'title'       => 'ต้องการยืนยันการตรวจสอบ',
            'description' => 'เอกสาร '.$this->req->req_code.' เรื่อง '.$this->req->req_title,
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'ยืนยัน',
                'method' => 'updateStatus',
                'params' => 2,
            ],
            'reject' => [
                'label'  => 'ยกเลิก',
                'method' => 'cancel',
            ],
        ]);
    }


    public function render()
    {

        $this->req = TrainingRequest::firstWhere('req_code',$this->code);
        return view('livewire.components.training-request-action');
    }
}
