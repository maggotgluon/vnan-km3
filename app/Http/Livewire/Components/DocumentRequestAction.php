<?php

namespace App\Http\Livewire\Components;

use App\Models\Document;
use App\Models\DocumentRequest;
use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;

class DocumentRequestAction extends Component
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
        // $this->req = DocumentRequest::firstWhere('req_code',$code);
    }
    public function updateStatus($status){
        // dd($this->req,$status);
        $this->req->req_status = $status;
        if($status === 2){
            $this->req->req_dateReview = now();
            $this->req->user_review = auth()->user()->id;
            if($this->req->req_obj == '7'){
                $status=3;
                $this->req->req_status = $status;
            }
        }
        if($status === 3){
            $this->req->req_dateApprove = now();
            $this->req->user_approve = auth()->user()->id;
            // dd($status,$status === 3,$this->req->req_obj);
            switch ($this->req->req_obj->value) {
                    case '1':
                        // dd($this->req->req_obj);
                        # code...
                        $this->create();
                        break;
                    case '2':
                        # code...
                        $this->createRevision();
                        break;
                    case '3':
                        $this->cancle();
                        break;
                    case '4':
                        # code...
                        break;
                    case '5':
                        # code...
                        break;
                    case '6':
                        $this->create();
                        # code...
                        break;
                    case '7':
                        $this->createRecord();
                        break;
                default:
                    # code...
                    break;
            }
        }
        if($this->comment){
            $this->req->remark = auth()->user()->name.' : '.$this->comment;
        }
        $this->req->save();
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
        $this->req = DocumentRequest::firstWhere('req_code',$this->code);
        return view('livewire.components.document-request-action');
    }

    // case create new doc obj1 6
    // concern document
    public function create(){
        // dd(User::find($this->req->user_id)->department);
        try {
            Document::create([
                'doc_type'=>$this->req->info->meta_value['type'],
                'doc_code'=>$this->req->req_title,
                'referance_req_code'=>$this->code,
                'doc_ver'=>$this->req->info->meta_value['ver']??0,
                'doc_name_th'=>$this->req->info->meta_value['name_th'],
                'doc_name_en'=>$this->req->info->meta_value['name_en'],
                'effective'=>$this->req->info->meta_value['effective'],
                'ages'=>$this->req->info->meta_value['age'],
                'department'=>User::find($this->req->user_id)->department->value,
                'status'=>1,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    // case revision obj2
    // concern revision
    public function createRevision(){
        // $this->req->info->meta_value['ver']+=1;

        Document::updateOrCreate([
            'doc_type'=>$this->req->info->meta_value['type'],
            'doc_code'=>$this->req->req_title,
            'referance_req_code'=>$this->code,
        ],[
            'doc_ver'=>$this->req->info->meta_value['ver'],
            'doc_name_th'=>$this->req->info->meta_value['name_th'],
            'doc_name_en'=>$this->req->info->meta_value['name_en'],
            'effective'=>$this->req->info->meta_value['effective'],
            'ages'=>$this->req->info->meta_value['age'],
            'department'=>User::find($this->req->user_id)->department->value,
            'status'=>2,
        ]);
    }

    // case cancle obj3
    // concern status
    public function cancle(){
        $doc = Document::updateOrInsert([
            'doc_code'=>$this->req->req_title,
            'status'=>1
        ],['status'=>-1]);
        
        // $doc->save();
    }

    // case copy / distruct obj4 5
    // not concern
    // public function approve(){}

    // case create new rec obj7
    // not concern
    public function createRecord(){
        $effective=$this->req->req_obj->value==7?'':$this->req->info->meta_value['rec_effective'];
        // dd($this->req->req_obj->value,$effective);
        Document::create([
            'doc_type'=>'record',
            'doc_code'=>$this->req->req_title,
            'referance_req_code'=>$this->code,
            'doc_name_th'=>$this->req->req_title,
            'doc_name_en'=>$this->req->req_title,
            'doc_ver'=>-1,
            'effective'=>now()->hour(0)->minute(0)->second(0),
            'department'=>User::find($this->req->user_id)->department->value,
            'ages'=>0,
            'status'=>1,
        ]);
    }
}
