<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    private $user;
    public $userdata;
    public $departmentList,$HODList;

    protected $rules = [
        "userdata.name" => 'required',
        "userdata.email"=>'nullable|email',
        "userdata.position"=>'required',
        "userdata.department"=>'required',
        "userdata.department_head"=>'required',
        "userdata.user_level"=>'required',
        "userdata.staff_id"=>'required',
    ];

    protected $messages = [
    ];

    public function mount($id=null){
        $this->user = User::firstWhere('staff_id',$id);
        $this->departmentList= User::all()->unique('department');
        $this->HODList = User::all();
    }
    public function clearProfile(){
        $this->userdata=[];
    }
    public function createProfile(){
        $this->validate();
        $userdata = $this->userdata;

        dd($userdata);
        $user = User::create([
            'name' => $this->userdata['name'],
            'staff_id' => $this->userdata['staff_id'],
            'email' => $this->userdata['email'],
            'position' => $this->userdata['position'],
            'department' => $this->userdata['department'],
            'department_head' => $this->userdata['department_head'],
            'user_level' => $this->userdata['user_level'],
        ]);
    }
    public function render()
    {
        return view('livewire.user.create',[
            'user'=>$this->user,
        ])->extends('layouts.app');
    }
}
