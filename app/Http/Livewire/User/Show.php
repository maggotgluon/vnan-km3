<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $selectuser;
    public bool $self=false, $editmode=false;

    public function mount($id){
        $this->selectuser = User::firstWhere('staff_id',$id);
        // dd($this->selectuser->staff_id,Auth::user()->staff_id);
        if($this->selectuser==Auth::user()){
            $this->self=true;
        }
    }
    public function toggleEditMode(){
        $this->editmode=!$this->editmode;
    }
    public function render()
    {
        return view('livewire.user.show',[
            'user'=>$this->selectuser,
        ])->extends('layouts.app');
    }
}
