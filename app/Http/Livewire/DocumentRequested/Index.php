<?php

namespace App\Http\Livewire\DocumentRequested;

use App\Models\DocumentRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        
        $this->reqs = DocumentRequest::with('info');
        // dd($this->reqs);

    }
    public function mount($id=null){
        if($id){
            $user = User::find($id);
            // dd(DocumentRequest::with('info')->whereBelongsTo($user));
            $this->reqs = DocumentRequest::with('info')->whereBelongsTo($user);
        }else{
            if(Gate::allows('publish_document')){
                $this->reqs = DocumentRequest::with('info')->where('req_status',2);
            }else{
                $this->reqs = DocumentRequest::with('info');
            }
        }
    }
    public function render()
    {

        if($this->filter_status){
            $this->reqs = $this->reqs->where('req_status',$this->filter_status);
        }
        if($this->search){
            $this->reqs = $this->reqs->where('req_title','like','%'.$this->search.'%');
        }
        if($this->reqs==null){

            $this->reqs = DocumentRequest::with('info');
        }
        return view('livewire.document-requested.index',[
            'requests'=>$this->reqs
            // ->where('req_obj',$this->filter_objective)
            ->orderBy('updated_at','desc')
            ->paginate(10)
        ])->extends('layouts.app');
    }
}
