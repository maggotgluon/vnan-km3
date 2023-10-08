<?php

namespace App\Http\Livewire\TrainingRequested\View;

use App\Models\TrainingRequest;
use App\Models\TrainingRequestInfo;
use App\Models\User;
use Livewire\Component;

class Fmlds009 extends Component
{
    // public TrainingRequest $req;
    public $info;
    public TrainingRequest $request;
    public function mount($id){
        $this->request = TrainingRequest::with('info')->firstWhere('req_code',$id);
        $this->info = TrainingRequestInfo::where('request_req_code',$id)->pluck('meta_value')[0];
        // dd($this->info['instructor']);
    }
    public function render()
    {
        $user = User::whereIn('id',[
            $this->request->user_id,
            $this->request->user_review,
            $this->request->user_approve,
            $this->info['instructor']
        ])->get();
        return view('livewire.training-requested.view.fmlds009',[
            'req'=>$this->request,
            'requester' => $user->find($this->request->user_id)??'',
            'instructor' => $user->find($this->info['instructor'])??'',
            'hod' => $user->find($this->info['instructor'])->hod()??'',
            'reviewer' => $user->find($this->request->user_review)??'',
            'approver' => $user->find($this->request->user_approve)??'',
        ])->extends('layouts.print');
    }
}
