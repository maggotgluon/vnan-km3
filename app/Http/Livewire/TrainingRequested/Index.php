<?php

namespace App\Http\Livewire\TrainingRequested;

use App\Models\TrainingRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private $reqs;
    public $search,$filter_status = 1 ,$filter_objective='internal';

    protected $listeners = ['actionUpdate' => 'actionUpdate'];

    protected $queryString = [
        'search' => ['except' => ''],
        'filter_status' => ['except' => '','except' =>1],
        'filter_objective' => ['except' => 'internal'],
    ];

    public function mount(){

    }
    public function actionUpdate(){
        $this->resetPage();

    }
    public function render()
    {
        $this->reqs = TrainingRequest::with('info');

        if($this->filter_status){
            $this->reqs = $this->reqs->where('req_status',$this->filter_status);
        }
        if($this->search){
            $this->reqs = $this->reqs->where('req_title','like','%'.$this->search.'%');
        }
        $this->reqs = $this->reqs->where('user_id',Auth::user()->id);
        return view('livewire.training-requested.index',[
            'requests'=>$this->reqs
            // ->where('req_status',$this->filter_status)
            // ->where('req_title','like','%'.$this->search.'%')
            ->where('req_obj',$this->filter_objective)
            ->orderBy('updated_at','desc')
            ->paginate(100)
        ])->extends('layouts.app');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
