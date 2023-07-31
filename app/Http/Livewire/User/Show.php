<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $selectuser,$userdata;
    public bool $self=false, $editmode=false,$editpassword=false;
    public $departmentList,$HODList;

    public function mount($id){
        $this->departmentList= User::all()->unique('department');
        // dd($this->departmentList);
        $this->selectuser = User::firstWhere('staff_id',$id);
        // dd($this->selectuser->staff_id,Auth::user()->staff_id);
        if($this->selectuser==Auth::user()){
            $this->self=true;
        }
    }
    public function toggleEditMode(){
        $this->editmode=!$this->editmode;
        $this->userdata = $this->selectuser->toArray();
        $this->HODList = $this->selectuser->colleague();
        $this->HODList = $this->selectuser->colleague();
        // dd($this->userdata);
    }
    public function togglePassword(){
        $this->editpassword = !$this->editpassword;
    }
    
    public function updatedUserdataDepartment(){
        // dd('department changed');
        $user = User::firstWhere('department',$this->userdata['department']);
        $this->HODList = $user->colleague();
        // dd($this->HODList[0]);
        $this->userdata['department_head']=$this->HODList[0]->id;
        // dd($this->HODList);
    }
    public function render()
    {
        return view('livewire.user.show',[
            'user'=>$this->selectuser,
        ])->extends('layouts.app');
    }
}
