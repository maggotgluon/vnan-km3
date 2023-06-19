<?php

namespace App\Http\Livewire\DocumentRequested;

use App\Models\DocumentRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private $reqs;
    public $search,$filter_status,$filter_objective;

    protected $listeners = ['actionUpdate' => 'actionUpdate'];

    protected $queryString = [
        'search' => ['except' => ''],
        'filter_status' => ['except' => '','except' =>1],
        'filter_objective' => ['except' => 'internal'],
    ];

    public function actionUpdate(){
        $this->resetPage();

    }
    public function render()
    {
        $this->reqs = DocumentRequest::with('info');

        if($this->filter_status){
            $this->reqs = $this->reqs->where('req_status',$this->filter_status);
        }
        if($this->search){
            $this->reqs = $this->reqs->where('req_title','like','%'.$this->search.'%');
        }

        return view('livewire.document-requested.index',[
            'requests'=>$this->reqs
            // ->where('req_obj',$this->filter_objective)
            ->orderBy('updated_at','desc')
            ->paginate(10)
        ])->extends('layouts.app');
    }
}
