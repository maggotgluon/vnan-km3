<?php

namespace App\Http\Livewire\TrainingRequested;

use App\Models\TrainingRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Show extends Component
{
    private $request;
    public $val;

    public function mount($id){
        $this->request = TrainingRequest::with('info')->where('req_code',$id)->first();
        // dd($this->request->req_obj);
        $validated = Validator::make($this->request->info->meta_value,[
            'title' => 'required',
            'start_date' => 'required',
            'start_time' => Rule::requiredIf($this->request->req_obj=='internal'),
            'end_date' => 'required',
            'end_time' => Rule::requiredIf($this->request->req_obj=='internal'),
            'instructor' => 'required',
        ]);
        /* $validated = Validator::make($this->request->info->meta_value,[
            'title' => Rule::requiredIf($this->request->req_obj=='internal'),
            'start_date' => Rule::requiredIf($this->request->req_obj=='internal'),
            'start_time' => Rule::requiredIf($this->request->req_obj=='internal'),
            'end_date' => Rule::requiredIf($this->request->req_obj=='internal'),
            'end_time' => Rule::requiredIf($this->request->req_obj=='internal'),
            'instructor' => Rule::requiredIf($this->request->req_obj=='internal'),
        ]); */
        $this->val=$validated->errors()->all()??null;
        \Log::info(\Auth::user()->name.' view '.$this->request->req_code.' '.$this->request->req_title);
        // dd($this->request->info->meta_value,$this->val);

    }
    public function render()
    {
        $user = User::whereIn('id',[
            $this->request->user_id,
            $this->request->user_review,
            $this->request->user_approve,
            $this->request->info->meta_value['instructor']
        ])->get();

        return view('livewire.training-requested.show',[
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
