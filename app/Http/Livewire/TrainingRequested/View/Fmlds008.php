<?php

namespace App\Http\Livewire\TrainingRequested\View;

use App\Models\TrainingRequest;
use App\Models\TrainingRequestInfo;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Fmlds008 extends Component
{
    // public TrainingRequest $req;
    public $info;
    public $val;
    public TrainingRequest $request;

    public function mount($id){
        $this->request = TrainingRequest::with('info')->firstWhere('req_code',$id);
        $this->info = TrainingRequestInfo::where('request_req_code',$id)->pluck('meta_value')[0];

        // dd($this->info);
        $validated = Validator::make($this->info,[
            'title' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'objective' => 'required',
            'subjectDetailsDiscription' => 'required',
            'information_time' => 'required',
            'activityDiscription' => 'required',
            'activity_time' => 'required',
            'evaluateDiscription' => 'required',
            'evaluate_time' => 'required',
        ]);
        $this->val=$validated->errors()->all();
        // dd($errors,$this->val);
        // dd($this->info,$validated->errors(),$validated->validated());
    }
    public function render()
    {
        $user = User::whereIn('id',[
            $this->request->user_id,
            $this->request->user_review,
            $this->request->user_approve,
            $this->info['instructor']
        ])->get();
        return view('livewire.training-requested.view.fmlds008',[
            'req'=>$this->request,
            'requester' => $user->find($this->request->user_id)??'',
            'instructor' => $user->find($this->info['instructor'])??'',
            'hod' => $user->find($this->info['instructor'])->hod()??'',
            'reviewer' => $user->find($this->request->user_review)??'',
            'approver' => $user->find($this->request->user_approve)??'',
        ])->extends('layouts.print');
    }
}
