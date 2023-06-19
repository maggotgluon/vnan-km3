<?php

namespace App\Http\Livewire\TrainingRequested;

use App\Models\TrainingRequest;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovedIndex extends Component
{
    use WithPagination;

    private $req;
    public $filter_search,$filter_objective,$filter_date_from,$filter_date_to,$filter_paginate=10,$filter_internal='internal';

    // public function updatedFilterSearch(){
    //     dd('search');
    // }
    public function clear(){
        $this->reset();
    }
    public function render()
    {
        $this->req = TrainingRequest::where('req_status',3)
            ->where('req_obj',$this->filter_internal)
            ->orderBy('updated_at','desc');
        if($this->filter_search){
            $this->req->where('req_title','like','%'.$this->filter_search.'%');
        }
        if($this->filter_objective){
            $this->req->where('req_obj',$this->filter_objective);
        }
        // if($this->filter_search){
        //     $this->req->info->meta_value->where('req_title',$this->filter_search);
        // }

        return view('livewire.training-requested.approved-index',[
            'requests'=>$this->req->paginate($this->filter_paginate)
        ])->extends('layouts.app');
    }
}
