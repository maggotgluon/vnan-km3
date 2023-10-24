<?php

namespace App\Http\Livewire\TrainingRequested\View;

use App\Models\TrainingRequest;
use App\Models\TrainingRequestInfo;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Fmlds006 extends Component
{
    // public TrainingRequest $req;
    // public $info;
    public TrainingRequest $request;
    public function mount($id){
        $this->request = TrainingRequest::with('info')->firstWhere('req_code',$id);
        // $this->info = TrainingRequestInfo::firstWhere('request_req_code',$id)->pluck('meta_value')[0];
        // dd($this->info['instructor']);

        // dd($this->info);
        $validated = Validator::make($this->request->info->meta_value,[
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'duration' => 'required',
            'venue' => 'required',
            'lecturer' => 'required',
            'institution' => 'required',
            'Hightlihts' => 'required',
            'applic_action' => 'required',
        ]);
        $this->val=$validated->errors()->all();
    }
    public function render()
    {

        $user = User::whereIn('id',[
            $this->request->user_id,
            $this->request->user_review,
            $this->request->user_approve,
            $this->request->info->meta_value['instructor']
        ])->get();
        // dd($user);
        return view('livewire.training-requested.view.fmlds006',[
            'req'=>$this->request,
            'info'=>$this->request->info->meta_value,
            'requester' => $user->find($this->request->user_id)??'',
            'instructor' => $user->find($this->request->info->meta_value['instructor'])??'',
            'hod' => $user->find($this->request->info->meta_value['instructor'])->hod()??'',
            'reviewer' => $user->find($this->request->user_review)??'',
            'approver' => $user->find($this->request->user_approve)??'',
        ])->extends('layouts.print');
    }
}
