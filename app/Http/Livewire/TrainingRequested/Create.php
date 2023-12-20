<?php

namespace App\Http\Livewire\TrainingRequested;

use App\Mail\TestMail;
use App\Models\TrainingRequest;
use App\Models\TrainingRequestInfo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Jobs\SendEmailTraining as SendEmail;

use WireUi\Traits\Actions;
use Livewire\WithFileUploads;

class Create extends Component
{
    use Actions;
    use WithFileUploads;

    public $objective;
    public $req_id;
    public $data = [],$file;
    public $mindate;
    public $edit_mode;


    protected $rules = [
        "objective" => 'required',
        "data.instructor" => 'required',
        "data.title" => 'required|min:6|regex:/^[-_ ก-๏a-zA-Z \d\s]+$/u|',
        "data.start_date" => 'required',
        "data.end_date" => 'required',
        "data.filePDF" => 'required|mimes:pdf'
        // "data.filePDF" => 'required|mimes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    protected $messages = [
        'data.title.required' => 'จำเป็นต้องระบุหัวข้อ',
        'data.title.regex' => 'กรุณาใช้ภาษาอังกฤษ หรือภาษาไทยเท่านั้น ไม่สามารถใส่อัขระพิเศษได้ (!"#$%&()*+,-./:;<=>?@[\]^_`{|}~)',
        'data.title.min' => 'ขั้นตำ่อย่างน้อย 6 ตัวอักษร',
    ];

    public function mount($id=null){
        // dd(Request::route()->getName() == 'training.request.create');
        if($id){
            $req=TrainingRequest::with('info')->firstWhere('req_code',$id);
            // dd($req,$id);
            $this->edit_mode=true;
            $this->req_id = $req->req_code;
            $this->objective = $req->req_obj;
            // dd( $req->info->meta_value );
            $this->data = $req->info->meta_value;
        }
        // $this->objective = 'internal';

        $this->data['instructor'] = Auth::user()->id;
        $this->mindate = TrainingRequest::getMinDate();
        $this->data['start_date']=$this->mindate;
        $this->data['end_date']=$this->mindate;
    }
    public function savedraft(){
        $validate = $this->validate([
            "objective" => 'required',
            "data.instructor" => 'required',
            "data.title" => 'required|min:6|regex:/^[-_ ก-๏a-zA-Z \d\s]+$/u|',
        ]);

        if($this->objective == 'internal'){
            $this->req_id = $this->req_id??TrainingRequest::getNewTrainNo();
        }else{
            $this->req_id = $this->req_id??TrainingRequest::getNewExternalNo();
        }

        // dd($this->data['title'],$this->req_id,Auth::user()->id);
        try {
            $this->store();

        } catch (\Throwable $th) {
            throw $th;
            dd($th);
        }
    }
    public function submit(){
        if($this->objective == 'internal'){
            $validate = $this->validate([
                "objective" => 'required',
                "data.instructor" => 'required',
                "data.title" => 'required|min:6|regex:/^[-_ ก-๏a-zA-Z \d\s]+$/u|',
                "data.start_date" => 'required',
                "data.start_time" => 'required',
                "data.end_date" => 'required',
                "data.end_time" => 'required',
                "data.subjectDetailsDiscription" => 'required',
                "data.information_time" => 'required',
                "data.activityDiscription" => 'required',
                "data.activity_time" => 'required',
                "data.evaluateDiscription" => 'required',
                "data.evaluate_time" => 'required',
                "data.assessmentProcess" => 'required',
                "data.assessmentTools" => 'required',
                "data.criteriamentPass" => 'required',
                "data.criteriamentNopass" => 'required',
                "data.filePDF" => 'required'
            ]);
            /* $v=Validator::validate($this->data, [
                'filePDF' => [
                    'required',
                    File::types(['pdf'])
                ],
            ]);
            dd($v); */
        }else{
            $validate = $this->validate([
                "data.instructor" => 'required',
                "data.title" => 'required|min:6|regex:/^[-_ ก-๏a-zA-Z \d\s]+$/u|',
                "data.start_date" => 'required',
                "data.end_date" => 'required',
                "data.duration" => 'required',
                "data.venue" => 'required',
                "data.lecturer" => 'required',
                "data.institution" => 'required',
                "data.Hightlihts" => 'required',
                "data.applic_action" => 'required',
                // "data.filePDF" => 'required|mimes:pdf'
            ]);
        }
        
        // $this->req_id = $this->req_id??TrainingRequest::getNewExternalNo();
        $this->store(1);

    }
    public function store($status=0){

        if($this->objective == 'internal'){
            $this->req_id = $this->req_id??TrainingRequest::getNewTrainNo();
        }else{
            $this->req_id = $this->req_id??TrainingRequest::getNewExternalNo();
        }

        $req = TrainingRequest::updateOrCreate([
            // check
            'req_code'=>$this->req_id,
            'req_obj'=>$this->objective,
        ],[
            'req_title'=>$this->data['title'],
            'req_status'=>$status,
            'user_id'=>Auth::user()->id,
            'req_dateReview'=>null,
            'user_review'=>null,
            'req_dateReview'=>null,
            'user_approve'=>null,
        ]);
        // dd($this->data);
        $info=TrainingRequestInfo::updateOrCreate([
            // check
            'request_req_code'=>$this->req_id,
        ],[
            'meta_value'=>$this->data,
        ]);
        \Log::channel('training_log')->info(Auth::user()->name.' update '.$this->req_id.' status '.$status.' data : '.$req.$info);
        $this->sendNotification($req);
    }
    public function render()
    {
        return view('livewire.training-requested.create')->extends('layouts.app');
    }
    public function updatedObjective(){
        $this->data=[];
        $this->data['instructor'] = Auth::user()->id;
        $this->data['start_date']=$this->mindate;
        $this->data['end_date']=$this->mindate;
        if($this->objective == 'external'){
            $this->data['start_date']=Carbon::now()->toDateString();
            $this->data['end_date']=Carbon::now()->toDateString();
        }
    }
    public function updatedDataFilePDF(){
        $filename = Str::camel($this->data['title']);
        $time = now()->valueOf();
        $ext = $this->data['filePDF']->getClientOriginalExtension();
        $this->data['filePDF'] = $this->data['filePDF']->storePubliclyAs('TrainingRequest', $filename.'-'.$time.'.'.$ext);

        $this->notification()->success(
            $title = 'บันทึก File เรียบร้อย',
            $description = $this->data['filePDF']
        );
    }
    public function updatedDataFilePDFCertificate(){
        // dd('file');
        $filename = Str::camel($this->data['title']).'-certificate';
        $time = now()->valueOf();
        $ext = $this->data['filePDF-certificate']->getClientOriginalExtension();
        $this->data['filePDF-certificate'] = $this->data['filePDF-certificate']->storePubliclyAs('TrainingRequest', $filename.'-'.$time.'.'.$ext);

        $this->notification()->success(
            $title = 'บันทึก File เรียบร้อย',
            $description = $this->data['filePDF-certificate']
        );
    }
    public function sendEmail($user=null){
        // dd($this->req_id);
        // dd(Auth::user()->user_level,Auth::user()->acknowledgment());
        // dd(Arr::pluck(Auth::user()->acknowledgment()->toArray(),'email'));
        // Mail::to(Arr::pluck(Auth::user()->acknowledgment()->toArray(),'email'))->send(new TestMail($this->req_id));
        // dd($user);
        $user?null:'self';
        switch ($user) {
            case 'acknowledgment':
                $sendTo=Auth::user()->acknowledgment();
                break;
            case 'trainingReviewer':
                $sendTo=Auth::user()->trainingReviewer();
                break;
            case 'trainingApprover':
                $sendTo=Auth::user()->trainingApprover();
                break;
            
            default:
                $sendTo=Auth::user();
                break;
        }
        /* dd(get_class($sendTo)==="App\Models\User" ); */
        if(get_class($sendTo)==="App\Models\User"){
            $email = $sendTo->email;
        }else{
            $email = array();
            foreach ($sendTo as $key => $value) {
                array_push($email, $value->email);
            }
        }
        // dd($email);
        $details = [
            'email' => $email, //Arr::pluck(Auth::user()->acknowledgment()->toArray(),
            'data'=>$this->req_id
        ];
        // dd($details);
        SendEmail::dispatch($details);
    }
    public function sendNotification(TrainingRequest $req){

        if($req->req_status){
            $this->dialog()->confirm([
                'title'       => 'เอกสารทำการส่งเรียบร้อย',
                'description' => 'ท่านต้องการส่งเอกสารเพิ่มหรือไม่',
                'icon'        => 'question',
                'accept'      => [
                    'label'  => 'ส่งเอกสารเพิ่ม',
                    'method' => 'resetForm',
                    // 'params' => 'Saved',
                ],
                'reject' => [
                    'label'  => 'ดูเอกสาร',
                    'method' => 'gotoView',
                    'params' => $req->req_code,
                ],
            ]);

            $this->sendEmail('trainingReviewer');

        }else{
            $this->notification()->success(
                $title = 'บันทึกสำเร็จ',
                $description = 'เอกสารของท่านได้บันทึกเรียบร้อย'
            );

            // if(Request::route()->getName() == 'training.request.create'){
                redirect()->route('training.request.edit',['id'=>$req->req_code]);
            // }
        }
        

    }

    public function resetForm(){
        $this->resetExcept('objective');

    }
    public function gotoView($req_code){
        return redirect()->route('training.request.show',$req_code);
        // dd('redirect',$req_code);


    }
}
