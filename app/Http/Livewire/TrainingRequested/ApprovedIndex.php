<?php

namespace App\Http\Livewire\TrainingRequested;

use App\Models\TrainingRequest;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovedIndex extends Component
{
    use WithPagination;

    private $req;
    public $filter_search,$filter_department,$filter_date_from,$filter_date_to,$filter_paginate,$filter_internal='internal';

    protected $queryString = [
        'filter_search' => ['except' => ''],
        'filter_department' => ['except' => '','except' =>1],
        'filter_paginate' => ['except' => 10],
        'page'
    ];
    // public function updatedFilterSearch(){
    //     dd('search');
    // }
    public function mount(){
        $this->filter_paginate=10;
        // $this->filter_department='Admissions';
    }
    public function clear(){
        $this->reset();
    }
    public function render()
    {
        $this->req = TrainingRequest::where('req_status',3)
            ->with('user')->with('info')
            ->where('req_obj',$this->filter_internal)
            ->orderBy('updated_at','desc');
        if($this->filter_search){
            $this->req->where('req_title','like','%'.$this->filter_search.'%');
        }
        if($this->filter_department){
            // $this->req->has('user->department',$this->filter_department);
            // $this->req->where('department',$this->filter_department);
        }
        // dd($this->req,$this->req->first()->user->department);
        // if($this->filter_search){
        //     $this->req->info->meta_value->where('req_title',$this->filter_search);
        // }
        
        return view('livewire.training-requested.approved-index',[
            'requests'=>$this->req->paginate($this->filter_paginate)
        ])->extends('layouts.app');
    }
}
