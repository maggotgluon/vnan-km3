<?php

namespace App\Http\Livewire\TrainingRequested;

use App\Models\TrainingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        // dd($this->reqs->get());
        if($this->filter_status){
            $this->reqs = $this->reqs->where('req_status',$this->filter_status);
        }
        if($this->search){
            $this->reqs = $this->reqs->where('req_title','like','%'.$this->search.'%');
        }
        $auth = Gate::inspect('review_trainDocument')->allowed()||Gate::inspect('publish_trainDocument')->allowed();
        // dd($auth->allowed(),$auth);
        if ($auth) {
            // dd('access denine');// The user can't update the post...
        }else{
            $this->reqs = $this->reqs->where('user_id',Auth::user()->id);
            // dd(Auth::user()->id);
        }
        return view('livewire.training-requested.index',[
            'requests'=>$this->reqs
            // ->where('req_status',$this->filter_status)
            // ->where('req_title','like','%'.$this->search.'%')
            ->where('req_obj',$this->filter_objective)
            ->orderBy('updated_at','desc')
            ->paginate(50)
        ])->extends('layouts.app');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
