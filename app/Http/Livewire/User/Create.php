<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    private $user;

    public function mount($id=null){
        $this->user = User::firstWhere('staff_id',$id);
    }
    public function render()
    {
        return view('livewire.user.create',[
            'user'=>$this->user,
        ])->extends('layouts.app');
    }
}
