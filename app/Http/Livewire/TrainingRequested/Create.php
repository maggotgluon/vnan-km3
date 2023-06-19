<?php

namespace App\Http\Livewire\TrainingRequested;

use App\Models\TrainingRequest;
use App\Models\TrainingRequestInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Illuminate\Support\Str;

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
        // "data.filePDF" => 'required|mimes:pdf'
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
        $validate = $this->validate();
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
        ]);
        // dd($this->data);
        TrainingRequestInfo::updateOrCreate([
            // check
            'request_req_code'=>$this->req_id,
        ],[
            'meta_value'=>$this->data,
        ]);

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
        $time = now();
        $ext = $this->data['filePDF']->getClientOriginalExtension();
        $this->data['filePDF'] = $this->data['filePDF']->storePubliclyAs('TrainingRequest', $filename.'-'.$time.'.'.$ext);

        $this->notification()->success(
            $title = 'บันทึก File เรียบร้อย',
            $description = $this->data['filePDF']
        );
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
