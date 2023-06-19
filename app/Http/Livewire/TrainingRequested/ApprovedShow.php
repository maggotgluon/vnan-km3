<?php

namespace App\Http\Livewire\TrainingRequested;

use App\Models\TrainingRequest;
use App\Models\User;
use Livewire\Component;

class ApprovedShow extends Component
{
    private $request;

    public function mount($id){
        $this->request = TrainingRequest::with('info')->where('req_code',$id)->first();

    }
    public function render()
    {
        $user = User::whereIn('id',[
            $this->request->user_id,
            $this->request->user_review,
            $this->request->user_approve,
            $this->request->info->meta_value['instructor']
        ])->get();

        return view('livewire.training-requested.approved-show',[
            'req'=>$this->request,
            'info'=>$this->request->info->meta_value,

            'requester' => $user->find($this->request->user_id)??'',
            'instructor' => $user->find($this->request->info->meta_value['instructor'])??'',
            'hod' => $user->find($this->request->info->meta_value['instructor'])->hod()??'',
            'reviewer' => $user->find($this->request->user_review)??'',
            'approver' => $user->find($this->request->user_approve)??'',
        ])->extends('layouts.app');
    }
}
