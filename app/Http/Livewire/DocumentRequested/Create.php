<?php

namespace App\Http\Livewire\DocumentRequested;

use App\Models\Document;
use App\Models\DocumentRequest;
use App\Models\DocumentRequestInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

use WireUi\Traits\Actions;
use Livewire\WithFileUploads;

class Create extends Component
{
    use Actions;
    use WithFileUploads;

    public $objective;
    public $req_id;
    public $data = [],$file;

    public $mindate,$year;

    public $edit_mode;
    public $documents,$selectedDocument;

    protected $rules = [
        "objective" => 'required',
        "data.type"=>'nullable',
        "data.code" => 'required', //pattern XX-XX-0000
        "data.name_th"=>'nullable|regex:/^[-_ ก-๏ \d\s]+$/u|min:6|',
        "data.name_en"=>'nullable|regex:/^[-_ a-zA-Z \d\s]+$/u|min:6|',
        "data.discription" => 'nullable|min:6|',
        "data.effective"=>'nullable',
        "data.age"=>'nullable',
        // "data.filePDF" => 'required|mimes:pdf'
        // "data.filePDF" => 'required|mimes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    protected $messages = [
        'data.title.required' => 'จำเป็นต้องระบุหัวข้อ',
        'data.title.regex' => 'กรุณาใช้ภาษาอังกฤษ หรือภาษาไทยเท่านั้น ไม่สามารถใส่อัขระพิเศษได้ (!"#$%&()*+,-./:;<=>?@[\]^_`{|}~)',
        'data.title.min' => 'ขั้นตำ่อย่างน้อย 6 ตัวอักษร',
    ];

    public function render()
    {
        return view('livewire.document-requested.create')->extends('layouts.app');
    }
    public function mount($id=null){
        if($id){
            $req=DocumentRequest::with('info')->firstWhere('req_code',$id);
            // dd($req,$id);
            $this->edit_mode=true;
            // $this->req_id = $req->req_code;
            $this->objective = $req->req_obj->value;
            // dd( $req->info->meta_value );
            $this->data = $req->info->meta_value;
            // dd($req,$req->info->meta_value);
            if(isset($req->info->meta_value['selectedDocument'])){

                $this->data['selectedDocument'] = $req->info->meta_value['selectedDocument'];
            }
        }
        $this->documents = Document::with('ref')->where('status',1)->whereNot('doc_type','record')->get();
        // dd($this->documents);
        // $this->objective = 'internal';
        $this->mindate = DocumentRequest::getMinDate();
        $this->year = Carbon::now()->year;

    }
    public function updatedObjective(){
        $this->data = [];
        if($this->objective == 4){
            // incase select distruct filter doc type FM
            $this->documents = Document::with('ref')->where('status',1)->whereNot('doc_type','record')->where('doc_type','FM')->get();
        }else{
            $this->documents = Document::with('ref')->where('status',1)->whereNot('doc_type','record')->get();
            $this->documents->all();
        }
        if($this->objective == 6){
            $this->data['type']='EX';
        }

        $this->data['age'] = 0;
        $this->data['effective'] = $this->mindate;
    }

    // set defult document age base on selected doc_type
    public function updatedDataType(){
        if($this->data['type'] <> 'FM'){
            $this->data['age'] = -1;
        }else{
            $this->data['age'] = 0;
        }
    }

    // record part
    // reset
    // public function updatedDataRecDepartmentStore(){
    //     $this->data['rec_effective']=null;
    // }
    public function updatedDataRecEffective(){
        $this->data['code'] = Str::upper($this->data['rec_department_store']);
        $this->data['code'] .='-'.Str::upper($this->data['rec_effective']);
    }

    // alway upper code
    public function updatedDataCode(){
        $this->data['code'] = Str::upper($this->data['code']);
    }

    public function updatedDataSelectedDocument(){
        $doc = $this->documents->find($this->data['selectedDocument']);
        // dd($doc);
        if($doc){
            $this->data['code'] = $doc->ref->info->meta_value['code'] ;
            $this->data['type'] = $doc->doc_type ;
            $this->data['name_th'] = $doc->ref->info->meta_value['name_th'] ;
            $this->data['name_en'] = $doc->ref->info->meta_value['name_en'] ;
            $this->data['effective'] = $doc->effective->toDateString();

            $this->data['age'] = $doc->ages;
            $this->data['ver'] = $doc->doc_ver;
        }else{
            $this->data['code'] = null;
            $this->data['type'] = null;
            $this->data['name_th'] = null;
            $this->data['name_en'] = null;
            $this->data['effective'] = null;

            $this->data['age'] = null;
            $this->data['ver'] = null;
        }
        // dd($this->documents, $this->selectedDocument,$doc,$this->data);

    }

    public function savedraft(){
        $this->validate();
        $this->store();
    }

    public function submit(){
        $this->validate();
        $this->store(1);
    }

    public function store($status=0){


        if($this->objective == 7){
            $this->req_id = $this->req_id??DocumentRequest::getNewRecordNo();
        }else{
            $this->req_id = $this->req_id??DocumentRequest::getNewDarNo();
        }
        // $this->data['code'] = $this->data['code'];
        // dd($this->req_id);
        if($this->objective == 2 ){
            // revision
            
            $this->data['ver']=($this->documents->find($this->data['selectedDocument'])->doc_ver??0) +1;
            // $doc = Document::where('doc_code','like','%'.$this->data['code'])->first();
            // $this->data['type']=$this->data['type']??$doc->doc_type;
        }

        if(isset($this->data['type'])){
            if($this->data['type']=='EX'){
                $this->data['code'] = $this->year.'-'.$this->data['code'];
                $this->data['age'] = -1;
            }
        }
        // dd($this->objective,$this->data,($this->data['type']??$this->data['rec_type']).'-'.$this->data['code']);
        $req=DocumentRequest::updateOrCreate([
            // check
            'req_code'=>$this->req_id,
            'req_obj'=>$this->objective,
        ],[
            'req_title'=>($this->data['type']??$this->data['rec_type']).'-'.$this->data['code'],
            'req_status'=>$status,
            'user_id'=>Auth::user()->id,
        ]);

        // assign code
        $filename = $this->req_id.'-'.($this->data['type']??$this->data['rec_type']).'-'.$this->data['code'];
        $time = now()->valueOf();
        // dd(is_string($this->data['file_pdf']),is_object($this->data['file_pdf']));
        if(isset($this->data['file_pdf']) && is_object($this->data['file_pdf']) ){
            $ext = $this->data['file_pdf']->getClientOriginalExtension();
            $this->data['file_pdf'] = $this->data['file_pdf']->storePubliclyAs('DocumentRequest', $filename.'-'.$time.'.'.$ext);
        }

        if(isset($this->data['file_word']) && is_object($this->data['file_word']) ){
            $ext = $this->data['file_word']->getClientOriginalExtension();
            $this->data['file_word'] = $this->data['file_word']->storePubliclyAs('DocumentRequest', $filename.'-'.$time.'.'.$ext);
        }

        DocumentRequestInfo::updateOrCreate([
            // check
            'request_req_code'=>$this->req_id,
        ],[
            'meta_value'=>$this->data,
        ]);


        $this->sendNotification($req);
    }

    public function sendNotification(DocumentRequest $req){

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
                redirect()->route('document.request.edit',['id'=>$req->req_code]);
            // }
        }
    }

    public function updatedDataFilePDF(){
        $this->notification()->success(
            $title = 'บันทึก File เรียบร้อย',
            $description = 'ระบบได้ทำการ บันทึก file เป็นการชั่วคราว กรุณาบันทึกฉบับร่างหรือส่งเพื่อจัดเก็บ File อย่างสมบูรณ์'
        );
    }

    public function resetForm(){
        redirect()->route('document.request.create');
        // $this->resetExcept('objective');

    }
    public function gotoView($req_code){
        return redirect()->route('document.request.show',$req_code);
        // dd('redirect',$req_code);


    }
}
